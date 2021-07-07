<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\AccountType;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index()
    {
    }
    public function create()
    {
        return view('profit-loss.create');
    }
    public function store(Request $request)
    {
        $incomeAccounts = Account::all()->where('account_type', 4);
        $expenseAccounts = Account::all()->where('account_type', 5);
        $currency = Currency::all()->where('id', session('currency_id'))->first();

        return view('reports.profitLoss')
            ->with('incomeAccounts', $incomeAccounts)
            ->with('expenseAccounts', $expenseAccounts)
            ->with('currency', $currency)
            ->with('fromData', $request->fromData)
            ->with('toData', $request->toData);
    }
}
