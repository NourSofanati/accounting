<?php

namespace App\Http\Controllers;

use App\Models\PurchasePayment;
use App\Models\Account;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Entry;
use App\Models\ExpenseCategory;
use App\Models\ExpenseReciept;
use App\Models\ExpenseRecieptItem;
use App\Models\ExpenseRecieptPayment;
use App\Models\Purchase;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PurchasePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function addPayment(Request $request, Purchase $purchase)
    {

        $usdCurrency = Currency::where('code', 'USD')->first();
        $sypCurrency = Currency::where('code', 'SYP')->first();
        $transaction = Transaction::find($purchase->transaction_id);
        if (session('currency_id') == $usdCurrency->id) {
            $currencyVALUE = $this->processUsdFifo($request->paidAmount);
            if ($currencyVALUE == 'error') {
                alert()->error('You don\'t have enought money exchanged to USD currency');
                return redirect()->back();
            }
            $unMirroredTransaction = Transaction::find($purchase->transaction_id);
            $mirroredTransaction = $this->createTransaction('(قيد معكوس) ' . $request->name, $request->date, $sypCurrency->id, 'هذا القيد معكوس...\n' . $request->description);
            $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
            $crRecord_mirrored = $this->createCreditEntry($exchange_expense_account->id, $sypCurrency->id, $request->paidAmount * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
            $drRecord_mirrored = $this->createDebitEntry($purchase->vendor->account_id, $sypCurrency->id, $request->paidAmount * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
            $crRecord = $this->createCreditEntry($request->designatedAccountId, $usdCurrency->id, $request->paidAmount, $unMirroredTransaction, $currencyVALUE);
            $drRecord = $this->createDebitEntry($purchase->vendor->account_id, $usdCurrency->id, $request->paidAmount, $unMirroredTransaction, $currencyVALUE);
        } else {
            $newTransaction = $this->createTransaction('دفعة للفاتورة ' . sprintf('%08d', $purchase->id), $request->date, $sypCurrency->id, 'تسديد دفعة للفاتورة');
            $crRecord = $this->createCreditEntry($request->designatedAccountId, $sypCurrency->id, $request->paidAmount, $transaction, $request->currency_value);
            $drRecord = $this->createDebitEntry($purchase->vendor->account_id, $sypCurrency->id, $request->paidAmount, $transaction, $request->currency_value);
            alert()->success('Successfully completed transaction');
        }


        $payment = PurchasePayment::create([
            'date' => $request->date,
            'amount' => $request->paidAmount,
            'purchase_id' => $purchase->id,
            'currency_value' => $request->currency_value,
            'payment_account' => $request->designatedAccountId
        ]);
        //$payment->paid_from = $request->designatedAccountId;
        return redirect()->route('purchases.show', $purchase);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchasePayment  $purchasePayment
     * @return \Illuminate\Http\Response
     */
    public function show(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchasePayment  $purchasePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchasePayment  $purchasePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchasePayment  $purchasePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchasePayment $purchasePayment)
    {
        //
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
}
