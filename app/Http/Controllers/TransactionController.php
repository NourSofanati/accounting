<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Currency;
use App\Models\Entry;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
        //dd($request->entries);
        $parentTransaction = Transaction::find($request->transaction_id);
        $parentTransaction->transaction_name = $request->name;
        $parentTransaction->transaction_date = $request->date;
        $parentTransaction->description = $request->description;
        $parentTransaction->currency_id = session('currency_id');
        $currency = Currency::all()->where('id', $parentTransaction->currency_id)->first();
        $sypCurrency = Currency::all()->where('id', '!=', $currency->id)->first();
        $parentTransaction->save();
        foreach ($request->entries as $entry) {
            if (isset($entry['dr'])) {
                Entry::create([
                    'dr' => $entry['dr'],
                    'account_id' => $entry['account_id'],
                    'transaction_id' => $request->transaction_id,
                    'currency_value' => $entry['currency_value'],
                    'currency_id' => session('currency_id'),
                ]);
            } else {
                Entry::create([
                    'cr' => $entry['cr'],
                    'account_id' => $entry['account_id'],
                    'transaction_id' => $request->transaction_id,
                    'currency_value' => $entry['currency_value'],
                    'currency_id' => session('currency_id'),
                ]);
            }
            if ($currency->code == 'USD') {
                $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
                $EEA_balance = $exchange_expense_account->_SYP_Balance();
                if (isset($entry['dr'])) {
                    Entry::create([
                        'dr' => $entry['dr'] * $entry['currency_value'],
                        'account_id' => $entry['account_id'],
                        'transaction_id' => $request->transaction_id,
                        'currency_value' => $entry['currency_value'],
                        'currency_id' => $sypCurrency->id,
                    ]);
                } else {
                    if ($EEA_balance >= $entry['cr'] * $entry['currency_value'])
                        Entry::create([
                            'cr' => $entry['cr'] * $entry['currency_value'],
                            'account_id' => $exchange_expense_account->id,
                            'transaction_id' => $request->transaction_id,
                            'currency_value' => $entry['currency_value'],
                            'currency_id' => $sypCurrency->id,
                        ]);
                    else if ($EEA_balance > 0) {
                        $remaining_amount = abs(($entry['cr'] * $entry['currency_value']) - $EEA_balance);
                        Entry::create([
                            'cr' => $EEA_balance,
                            'account_id' => $exchange_expense_account->id,
                            'transaction_id' => $request->transaction_id,
                            'currency_value' => $entry['currency_value'],
                            'currency_id' => $sypCurrency->id,
                        ]);
                        Entry::create([
                            'cr' => $remaining_amount,
                            'account_id' => $entry['account_id'],
                            'transaction_id' => $request->transaction_id,
                            'currency_value' => $entry['currency_value'],
                            'currency_id' => $sypCurrency->id,
                        ]);
                    } else {
                        Entry::create([
                            'cr' => $entry['cr'] * $entry['currency_value'],
                            'account_id' => $entry['account_id'],
                            'transaction_id' => $request->transaction_id,
                            'currency_value' => $entry['currency_value'],
                            'currency_id' => $sypCurrency->id,
                        ]);
                    }
                }
            }
        }
        return redirect()->route('dashboard');
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
        $arr = explode("/", $request->session()->previousUrl());
        $account = Account::find($arr[count($arr) - 1]);
        return view('transactions.show')->with('transaction', $transaction)->with('account', $account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
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
