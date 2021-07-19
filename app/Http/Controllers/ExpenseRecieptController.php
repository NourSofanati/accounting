<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Entry;
use App\Models\ExpenseCategory;
use App\Models\ExpenseReciept;
use App\Models\ExpenseRecieptItem;
use App\Models\ExpenseRecieptPayment;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseRecieptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expenses.index')
            ->with('expenses', ExpenseReciept::all())
            ->with('currency', Currency::all()->where('id', session('currency_id'))->first());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $draftexpenseReciept = ExpenseReciept::create();
        $cashAccounts = Account::all()->where('account_type', 1)->all();
        $vendors = Vendor::all();
        $categories = ExpenseCategory::all();
        return view('expenses.create')
            ->with('cashAccounts', $cashAccounts)
            ->with('vendors', $vendors)
            ->with('draftexpenseReciept', $draftexpenseReciept)
            ->with('categories', $categories)
            ->with('currency', Currency::all()->where('id', session('currency_id'))->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $usdCurrency = Currency::where('code', 'USD')->first();
        $sypCurrency = Currency::where('code', 'SYP')->first();
        $reciept = ExpenseReciept::find($request->expenseRecieptNumber);
        $reciept->issueDate = $request->issueDate;
        $reciept->dueDate = $request->dueDate;
        $reciept->vendor_id = $request->vendor_id;
        $reciept->asset_id = $request->asset_id;
        $reciept->expense_id = $request->expense_id;
        $recieptTransaction = Transaction::create([
            'transaction_name' => 'Receipt ' . sprintf("%07d", $reciept->id),
            'transaction_date' => $reciept->issueDate,
        ]);
        $reciept->transaction_id = $recieptTransaction->id;

        foreach ($request->entries as $index => $entry) {
            ExpenseRecieptItem::create([
                'reciept_id' => $reciept->id,
                'rate' => $entry['rate'],
                'qty' => $entry['qty'],
                'description' => $entry['description'],
                'currency_value' => $request->currency_value,
                'currency_id' => $request->session()->get('currency_id'),
            ]);
            $this->createCreditEntry($reciept->vendor->account_id, $sypCurrency->id, $entry['rate'] * $entry['qty'], $recieptTransaction, $request->currency_value);
            $this->createDebitEntry($reciept->expense_id, $sypCurrency->id, $entry['rate'] * $entry['qty'], $recieptTransaction, $request->currency_value);
        }

        $reciept->save();
        return redirect()->route('expenses.index');
    }

    function processUsdFifo($RecieptTotal)
    {
        $usdCurrency = Currency::where('code', 'USD')->first();
        if (session('currency_id') != $usdCurrency->id) return;
        $allExchanges = CurrencyExchange::whereColumn('amount', '>', 'amount_spent')->where('currency_to', $usdCurrency->id)->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();
        $batches = array();
        $amount = 0;
        $totalAvailableAmount = 0;
        $totalRemainingAmount = $RecieptTotal; // 2000
        $totalAmountSyp = 0; // 0
        $count = 0;
        foreach ($allExchanges as $batch) {
            $totalAvailableAmount += $batch->amount - $batch->amount_spent;
            array_push($batches, $batch);
            $count++;
            if ($totalAvailableAmount >= $RecieptTotal) {
                foreach ($batches as $b) {
                    if ($b->amount - $b->amount_spent >= $totalRemainingAmount) {

                        $amount += $totalRemainingAmount; // 1000$ + 1000$ = 2000$
                        $totalAmountSyp += $totalRemainingAmount * $b->currency_value; //500,000s.p += 1000$ * 600 = 1,100,000
                        $b->amount_spent += $totalRemainingAmount;
                        $b->save();
                        break;
                    } else {
                        $totalRemainingAmount -= ($b->amount - $b->amount_spent); //2000 - 1000 = 1000
                        $amount += $b->amount - $b->amount_spent; // 1000
                        $totalAmountSyp += $amount * $b->currency_value; // 1000 * 500 = 500,000
                        $b->amount_spent += $b->amount - $b->amount_spent;
                        $b->save();
                    }
                }
                break;
            }
        }
        if ($totalAvailableAmount < $RecieptTotal) {
            return 'error';
        }
        toast()->success('Successfully spent ' . $totalAmountSyp . ' at the currency_value of ' . $totalAmountSyp / $amount);
        return $totalAmountSyp / $amount; // array('TotalAmountSyp' => $totalAmountSyp, 'TotalAmountUsd' => $amount);
    }

    public function createTransaction($transaction_name, $transaction_date, $currency_id, $description): Transaction
    {
        $transaction = Transaction::create([
            'transaction_name' => $transaction_name,
            'transaction_date' => $transaction_date,
            'currnecy_id' => $currency_id,
            'description' => $description,
        ]);
        return $transaction;
    }

    public function createCreditEntry($account_id, $currency_id, $amount, Transaction $transaction, $currency_value): Entry
    {
        $crEntry = Entry::create([
            'cr' => $amount,
            'account_id' => $account_id,
            'currency_id' => $currency_id,
            'currency_value' => $currency_value,
            'transaction_id' => $transaction->id,
        ]);
        return $crEntry;
    }
    public function createDebitEntry($account_id, $currency_id, $amount, Transaction $transaction, $currency_value): Entry
    {
        $drEntry = Entry::create([
            'dr' => $amount,
            'account_id' => $account_id,
            'currency_id' => $currency_id,
            'currency_value' => $currency_value,
            'transaction_id' => $transaction->id,
        ]);
        return $drEntry;
    }


    public function addExpensePage(ExpenseReciept $reciept)
    {
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('expenses.payment')->with('reciept', $reciept)->with('parentAccounts', $accounts);
    }

    public function addExpense(Request $request, ExpenseReciept $reciept)
    {

        $usdCurrency = Currency::where('code', 'USD')->first();
        $sypCurrency = Currency::where('code', 'SYP')->first();
        $transaction = Transaction::find($reciept->transaction_id);
        if (session('currency_id') == $usdCurrency->id) {
            $currencyVALUE = $this->processUsdFifo($request->paidAmount);
            if ($currencyVALUE == 'error') {
                alert()->error('You don\'t have enought money exchanged to USD currency');
                return redirect()->back();
            }
            $unMirroredTransaction = Transaction::find($reciept->transaction_id);
            $mirroredTransaction = $this->createTransaction('(قيد معكوس) ' . $request->name, $request->date, $sypCurrency->id, 'هذا القيد معكوس...\n' . $request->description);
            $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
            $crRecord_mirrored = $this->createCreditEntry($exchange_expense_account->id, $sypCurrency->id, $request->paidAmount * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
            $drRecord_mirrored = $this->createDebitEntry($reciept->vendor->account_id, $sypCurrency->id, $request->paidAmount * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
            $crRecord = $this->createCreditEntry($request->designatedAccountId, $usdCurrency->id, $request->paidAmount, $unMirroredTransaction, $currencyVALUE);
            $drRecord = $this->createDebitEntry($reciept->vendor->account_id, $usdCurrency->id, $request->paidAmount, $unMirroredTransaction, $currencyVALUE);
        } else {
            $newTransaction = $this->createTransaction('دفعة للفاتورة ' . sprintf('%08d', $reciept->id), $request->date, $sypCurrency->id, 'تسديد دفعة للفاتورة');
            $crRecord = $this->createCreditEntry($request->designatedAccountId, $sypCurrency->id, $request->paidAmount, $transaction, $request->currency_value);
            $drRecord = $this->createDebitEntry($reciept->vendor->account_id, $sypCurrency->id, $request->paidAmount, $transaction, $request->currency_value);
            alert()->success('Successfully completed transaction');
        }


        $payment = ExpenseRecieptPayment::create([
            'date' => $request->date,
            'amount' => $request->paidAmount,
            'reciept_id' => $reciept->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
            'paid_from' => $request->designatedAccountId
        ]);
        //$payment->paid_from = $request->designatedAccountId;
        return redirect()->route('expenses.show', $reciept);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function show($expenseReciept)
    {

        $dueAmount = 0;
        $expenseReciept = ExpenseReciept::findOrFail($expenseReciept);

        foreach ($expenseReciept->items as $item) {
            $dueAmount += ($item->qty * $item->rate);
        }
        return view('expenses.show')
            ->with('reciept', $expenseReciept)
            ->with('dueAmount', $dueAmount)
            ->with('currency', Currency::all()->where('id', session('currency_id'))->first());
    }

    public function refund($r)
    {
        $expenseReciept = ExpenseReciept::findOrFail($r);
        $sypCurrency = Currency::where('code', 'SYP')->first();
        $transaction = $this->createTransaction('مرتجع ' . sprintf('%08d', $expenseReciept->id), date(Carbon::today()), $sypCurrency->id, 'قيد مرتجع');
        foreach ($expenseReciept->payments as $payment) {
            $cr = $this->createCreditEntry($expenseReciept->expense_id, $sypCurrency->id, $payment->amount, $transaction, $payment->currency_value);
            $dr = $this->createDebitEntry($payment->paid_from, $sypCurrency->id, $payment->amount, $transaction, $payment->currency_value);
            $payment->refunded = true;
            $payment->save();
        }
        $expenseReciept->refunded = true;
        $expenseReciept->save();
        return redirect()->route('expenses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseReciept $expenseReciept)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseReciept $expenseReciept)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseReciept $expenseReciept)
    {
        //
    }
}
