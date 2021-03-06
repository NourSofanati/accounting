<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;

class CurrencyRateController extends Controller
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
        CurrencyRate::create(['currency_rate' => $request->currency_rate]);
        return redirect()->route('accounts-chart');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CurrencyRate  $currencyRate
     * @return \Illuminate\Http\Response
     */
    public function show(CurrencyRate $currencyRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CurrencyRate  $currencyRate
     * @return \Illuminate\Http\Response
     */
    public function edit(CurrencyRate $currencyRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CurrencyRate  $currencyRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CurrencyRate $currencyRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CurrencyRate  $currencyRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(CurrencyRate $currencyRate)
    {
        //
    }
}
