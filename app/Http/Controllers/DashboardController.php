<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->session()->has('currency_id')) {
            session(['currency_id' => 1]);
        }
        $accounts = Account::all();
        $expenseAccounts = $accounts->where('account_type', 5);
        $activeExpenseAccounts = [];
        foreach ($expenseAccounts as $a) {
            if ($a->ledgerBalance()) {
                array_push($activeExpenseAccounts, array('name' => $a->name, 'balance' => abs($a->ledgerBalance()), 'parent' => $a->parent? $a->parent->name : '', 'id' => $a->id));
            }
        }
        $parentCashAccount = Account::where('name', 'النقد')->first();
        $currency = Currency::all()->where('id', session('currency_id'))->first();
        //dd($parentCashAccount->children);
        return view('dashboard.index', ['expenseAccounts' => $activeExpenseAccounts, 'invoices' => $this->invoices(), 'currency' => $currency, 'cashAccounts' => $parentCashAccount->children]);
    }
    public function invoices()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->where('currency_id', session('currency_id'))->get();

        $colors = array(
            "مسودة" => "gray",
            "مرسلة" => "yellow",
            "مدفوعة" => "green"
        );
        $revenueSplit = array(
            "draft" => 0,
            "recievables" => 0,
            "paid" => 0,
            "paidTaxes" => 0,
            "retains" => 0,
        );
        foreach ($invoices as $invoice) {
            if ($invoice->status == "مسودة") {
                $revenueSplit["draft"] += $invoice->totalDue();
            } else {
                $revenueSplit["recievables"] += $invoice->totalDue();
                $revenueSplit["paid"] += $invoice->totalPaid() - $invoice->totalTaxes();
                $revenueSplit["paidTaxes"] += $invoice->totalTaxes();
                $revenueSplit["retains"] += $invoice->totalRetains();
            }
        }
        return $revenueSplit;
    }

    public function profits()
    {
        $incomeAccounts = Account::all()->where('account_type', 4);
        $expenseAccounts = Account::all()->where('account_type', 5);
        $months = array(
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
            array('expenses' => array(), 'income' => array()),
        );
        foreach ($expenseAccounts as $acc) {
            if ($acc->entries->count()) {
                foreach ($acc->entries as $entry) {
                    //dd(Carbon::create($entry->transaction->transaction_date)->format('m')); // 03
                    $month = Carbon::create($entry->transaction->transaction_date)->format('m');
                    array_push($months[$month - 1]['expenses'], $entry);
                }
            }
        }
        foreach ($incomeAccounts as $acc) {
            if ($acc->entries->count()) {
                foreach ($acc->entries as $entry) {
                    //dd(Carbon::create($entry->transaction->transaction_date)->format('m')); // 03
                    $month = Carbon::create($entry->transaction->transaction_date)->format('m');
                    array_push($months[$month - 1]['income'], $entry);
                }
            }
        }
        return $months;
    }
}
