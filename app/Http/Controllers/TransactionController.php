<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Attachment;
use App\Models\AttachmentGroup;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Entry;
use App\Models\Transaction;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
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
    public function getUSDprice()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sp-today.com/app_api/cur_damascus.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfduid=d7a4fb1bb5b25294faef13949ef102ae21615128843'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $USDprice = (array_filter(json_decode($response), function ($arrItem) {
            return $arrItem->name == 'USD';
        }));
        return $USDprice;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = AccountType::all();
        $USDprice = (int) $this->getUSDprice()[0]->bid;
        //dd($USDprice);


        return view('journal.create', ['accountTypes' => $accountTypes, 'USDprice' => $USDprice]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $usdCurrency = Currency::where('code', 'USD')->first();
        $sypCurrency = Currency::where('code', 'SYP')->first();
        $transactions = [];
        if (session('currency_id') == $usdCurrency->id) {
            $currencyVALUE = $this->processUsdFifo($request);
            if ($currencyVALUE == 'error') {
                alert()->error('You don\'t have enought money exchanged to USD currency');
                return redirect()->back();
            }
            $unMirroredTransaction = $this->createTransaction($request->name, $request->date, $sypCurrency->id, $request->description);
            $mirroredTransaction = $this->createTransaction('(قيد معكوس) ' . $request->name, $request->date, $sypCurrency->id, 'هذا القيد معكوس...\n' . $request->description);
            $unMirroredTransaction->mirror_id = $mirroredTransaction->id;
            $unMirroredTransaction->save();
            $mirroredTransaction->mirror_id = $unMirroredTransaction->id;
            $mirroredTransaction->save();
            $transactions[] = $mirroredTransaction;
            $transactions[] = $unMirroredTransaction;
            $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
            foreach ($request->entries as $entry) {
                if (isset($entry['cr'])) {
                    $crRecord_mirrored = $this->createCreditEntry($exchange_expense_account->id, $sypCurrency->id, $entry['cr'] * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
                    $crRecord = $this->createCreditEntry($entry['account_id'], $usdCurrency->id, $entry['cr'], $unMirroredTransaction, $currencyVALUE);
                } else if (isset($entry['dr'])) {
                    $drRecord_mirrored = $this->createDebitEntry($entry['account_id'], $sypCurrency->id, $entry['dr'] * $currencyVALUE, $mirroredTransaction, $currencyVALUE);
                    $drRecord = $this->createDebitEntry($entry['account_id'], $usdCurrency->id, $entry['dr'], $unMirroredTransaction, $currencyVALUE);
                }
            }
        } else {
            $newTransaction = $this->createTransaction($request->name, $request->date, $sypCurrency->id, $request->description);
            foreach ($request->entries as $entry) {
                if (isset($entry['cr'])) {
                    $crRecord = $this->createCreditEntry($entry['account_id'], $sypCurrency->id, $entry['cr'], $newTransaction, $entry['currency_value']);
                } else if (isset($entry['dr'])) {
                    $drRecord = $this->createDebitEntry($entry['account_id'], $sypCurrency->id, $entry['dr'], $newTransaction, $entry['currency_value']);
                }
            }
            alert()->success('Successfully completed transaction');
            $transactions[] = $newTransaction;
        }
        $files = ($request->file('attachment'));
        if ($request->hasFile('attachment')) {
            $fileNameArr = [];
            foreach ($files as $file) {
                $uri = time() . '-' . $file->getClientOriginalName();
                $fileNameArr[] = $uri;
                $file->move(public_path('attachments'), $uri);
                foreach ($transactions as $transaction) {
                    Attachment::create(['url' => $uri, 'group_id' => $transaction->attachment_group_id, 'name' => $file->getclientOriginalName()]);
                }
            }
        }

        return redirect()->route('accounts-chart');
    }

    function processUsdFifo(Request $request)
    {
        $usdCurrency = Currency::where('code', 'USD')->first();
        if (session('currency_id') != $usdCurrency->id) return;
        $allExchanges = CurrencyExchange::whereColumn('amount', '>', 'amount_spent')->where('currency_to', $usdCurrency->id)->orderBy('date', 'asc')->orderBy('created_at', 'asc')->get();
        $batches = array();
        $amount = 0;
        $totalAvailableAmount = 0;
        $totalRemainingAmount = $request->totalCr; // 2000
        $totalAmountSyp = 0; // 0
        $count = 0;
        foreach ($allExchanges as $batch) {
            $totalAvailableAmount += $batch->amount - $batch->amount_spent;
            array_push($batches, $batch);
            $count++;
            if ($totalAvailableAmount >= $request->totalCr) {
                foreach ($batches as $b) {
                    //1st run - $1000
                    //2nd run - $1000
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
        if ($totalAvailableAmount < $request->totalCr) {
            return 'error';
        }
        toast()->success('Successfully spent ' . $totalAmountSyp . ' at the currency_value of ' . $totalAmountSyp / $amount);
        return $totalAmountSyp / $amount; // array('TotalAmountSyp' => $totalAmountSyp, 'TotalAmountUsd' => $amount);
    }

    public function createTransaction($transaction_name, $transaction_date, $currency_id, $description)
    {
        $attachmentGroup = AttachmentGroup::create([]);
        $transaction = Transaction::create([
            'transaction_name' => $transaction_name,
            'transaction_date' => $transaction_date,
            'currnecy_id' => $currency_id,
            'description' => $description,
            'attachment_group_id' => $attachmentGroup->id,
        ]);
        return $transaction;
    }

    public function createCreditEntry($account_id, $currency_id, $amount, Transaction $transaction, $currency_value)
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
    public function createDebitEntry($account_id, $currency_id, $amount, Transaction $transaction, $currency_value)
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $transaction_id)
    {
        $transaction = Transaction::find($transaction_id);

        return view('transactions.show')->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($transaction_id)
    {

        $transaction = Transaction::find($transaction_id);
        $USDprice = (int) $this->getUSDprice()[0]->bid;

        return view('journal.edit', ['transaction' => $transaction, 'USDprice' => $USDprice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        $transaction->update($request->all());

        $entries = $transaction->entries;
        $currency_id = $entries[0]['currency_id'];
        foreach ($entries as $entry) {
            $entry->delete();
        }
        $transaction->save();
        foreach ($request->entries as $entry) {
            if (isset($entry['cr'])) {
                $crRecord = $this->createCreditEntry($entry['account_id'], $currency_id, $entry['cr'], $transaction, $entry['currency_value']);
            } else if (isset($entry['dr'])) {
                $drRecord = $this->createDebitEntry($entry['account_id'], $currency_id, $entry['dr'], $transaction, $entry['currency_value']);
            }
        }
        alert()->success('تم تعديل العملية بنجاح');
        return redirect()->route('journals.show', $transaction->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
