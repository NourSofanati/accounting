<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function index()
    {
        $types = AccountType::with('accounts')->get();
        return view('reports.balanceSheet')->with('types', $types);
    }
}
