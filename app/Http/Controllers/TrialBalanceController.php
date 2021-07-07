<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{

    public function index()
    {
        $currency = Currency::all()->where('id', session('currency_id'))->first();
        return view('reports.trialBalance')->with('accounts', Account::all())->with('currency', $currency);
    }

    public function create()
    {
        return view('profit-loss.create');
    }
}
