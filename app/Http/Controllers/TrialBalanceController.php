<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Transaction;
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
        $transactions = Transaction::where('transaction_date', '!=', null)->orderBy('transaction_date', 'asc')->get();
        $firstDate = $transactions->first()->transaction_date;
        $lastDate = $transactions->last()->transaction_date;
        return view('trialBalance.create', ['firstDate' => $firstDate, 'lastDate' => $lastDate]);
    }
    public function store(Request $request)
    {
        $currency = Currency::all()->where('id', session('currency_id'))->first();

        return view('reports.trialBalance')->with('accounts', Account::all())->with('currency', $currency);
    }
}
