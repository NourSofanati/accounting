<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Currency;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function index()
    {
        $types = AccountType::with('accounts')->get();
        $currency = Currency::all()->where('id', session('currency_id'))->first();
        $otherCurrency = Currency::all()->where('id', '!=', session('currency_id'))->first();

        return view('reports.balanceSheet', ['types' => $types, 'currency' => $currency, 'otherCurrency' => $otherCurrency]);
    }
    public function create()
    {
        
    }
}
