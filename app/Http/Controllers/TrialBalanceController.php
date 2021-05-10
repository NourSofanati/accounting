<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{
    public function index()
    {
        return view('reports.trialBalance')->with('accounts', Account::all());
    }
}
