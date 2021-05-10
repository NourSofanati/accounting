<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index()
    {
        $incomeAccounts = Account::all()->where('account_type', 4);
        $expenseAccounts = Account::all()->where('account_type', 5);

        return view('reports.profitLoss')
            ->with('incomeAccounts', $incomeAccounts)
            ->with('expenseAccounts', $expenseAccounts);
    }
}
