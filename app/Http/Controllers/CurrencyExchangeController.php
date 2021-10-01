<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Entry;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exchange.index', ['exchanges' => CurrencyExchange::orderBy('date', 'desc')->orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $USDprice = $this->getUSDprice();
        $currencies = Currency::all();


        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);

        return view('exchange.create')
            ->with('cashAccounts', $accounts)
            ->with('USDprice', $USDprice[0]->bid)
            ->with('currencies', $currencies);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currency_from = Currency::all()->where('id', $request->currency_from)->first();
        $currency_to = Currency::all()->where('id', $request->currency_to)->first();
        $account_from = Account::all()->where('id', $request->exchange_from)->first();
        $account_to = Account::all()->where('id', $request->exchange_to)->first();
        $amount = 0;
        if ($currency_from->code == 'USD') {
            $amount = $request->currency_value * $request->exchange_value;
            $transaction = Transaction::create([
                'transaction_name' => 'Currency Convert to ' . $currency_to->code . Carbon::now(),
                'transaction_date' => $request->issueDate,

            ]);
            $this->handleExchangeFrom($request->exchange_value, $account_from, $transaction, $currency_from, $request->currency_value);
            $this->handleExchangeTo($amount, $account_to, $transaction, $currency_to, $request->currency_value);
        } else {
            $amount =  $request->exchange_value / $request->currency_value;
            $transaction_syp = Transaction::create([
                'transaction_name' => '(SYP) Currency Convert from ' . $currency_from->code . Carbon::now(),
                'transaction_date' => $request->issueDate,
                'currnecy_id' => $currency_from->id,
            ]);
            $transaction_usd = Transaction::create([
                'transaction_name' => '(USD) Currency Convert to ' . $currency_to->code . Carbon::now(),
                'transaction_date' => $request->issueDate,
                'currnecy_id' => $currency_to->id,
            ]);
            $transaction_syp->mirror_id = $transaction_usd->id;
            $transaction_usd->mirror_id = $transaction_syp->id;

            $transaction_syp->save();
            $transaction_usd->save();

            $this->handleExchangeFrom($request->exchange_value, $account_from, $transaction_syp, $currency_from, $request->currency_value);
            $this->handleExchangeTo($amount, $account_to, $transaction_usd, $currency_to, $request->currency_value);
        }
        CurrencyExchange::create([
            'amount' => $amount,
            'amount_spent' => 0,
            'currency_to' => $currency_to->id,
            'date' => $request->issueDate,
            'currency_value' => $request->currency_value
        ]);
        return redirect()->route('exchange.index');
    }

    public function handleExchangeFrom($amount, $account_from, $transaction, $currency_from, $currency_value)
    {
        $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
        Entry::create([
            'cr' => $amount,
            'account_id' => $account_from->id,
            'transaction_id' => $transaction->id,
            'currency_id' => $currency_from->id,
            'currency_value' => $currency_value,
        ]);
        Entry::create([
            'dr' => $amount,
            'account_id' => $exchange_expense_account->id,
            'transaction_id' => $transaction->id,
            'currency_id' => $currency_from->id,
            'currency_value' => $currency_value,
        ]);
    }


    public function handleExchangeTo($amount, $account_to, $transaction, $currency_to, $currency_value)
    {
        $exchange_income_account = Account::all()->where('name', 'ايرادات تحويل عملة')->first();
        Entry::create([
            'dr' => $amount,
            'account_id' => $account_to->id,
            'transaction_id' => $transaction->id,
            'currency_id' => $currency_to->id,
            'currency_value' => $currency_value,
        ]);
        Entry::create([
            'cr' => $amount,
            'account_id' => $exchange_income_account->id,
            'transaction_id' => $transaction->id,
            'currency_id' => $currency_to->id,
            'currency_value' => $currency_value,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Http\Response
     */
    public function show(CurrencyExchange $currencyExchange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Http\Response
     */
    public function edit(CurrencyExchange $currencyExchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CurrencyExchange $currencyExchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Http\Response
     */
    public function destroy(CurrencyExchange $currencyExchange)
    {
        //
    }
}
