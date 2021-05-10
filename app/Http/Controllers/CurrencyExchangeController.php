<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\CurrencyExchange;
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
        return view('exchange.index');
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
        //
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
