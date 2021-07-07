<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\MonthlyReport;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('monthly-report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fromData = Carbon::create($request->fromData);
        $toData = Carbon::create($request->toData);
        $transactions = Transaction::all()->whereBetween('transaction_date', array($fromData, $toData));
        $income = 0;
        $grossIncome = 0;
        $expenses = 0;
        $taxes = 0;
        $retains = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->invoice) {
                $invoice = $transaction->invoice;
                $retains += $invoice->totalRetains();
                //$taxes += $invoice->totalTaxes();
                //$income += $invoice->total();
                $grossIncome  += $invoice->totalPaid();
            }
            foreach ($transaction->entries as $entry) {
                if (isset($entry['dr']) && $entry->account->accountType->name == 'نفقات' && $entry->currency->code == 'SYP') {
                    if (isset($entry->account->parent) && $entry->account->parent->name == 'ضرائب مدفوعة')
                        $taxes += $entry->dr;
                    else {
                        $expenses += $entry->dr;
                    }
                }
                if (isset($entry['cr']) && $entry->account->accountType->name == 'دخل' && $entry->currency->code == 'SYP') {
                    //if (isset($entry->account->parent) && $entry->account->parent->name == 'ضرائب مدفوعة')
                    $income += $entry['cr'];
                }
            }
        }
        $equityAccountsParent = Account::all()->where('name', 'الملكية')->first();
        $totalEquity = $equityAccountsParent->balance();
        $equityAccounts = $equityAccountsParent->children;


        //dd(['totalIncome' => $income, 'taxes' => $taxes, 'retains' => $retains,  'totalPaid' => $grossIncome - $taxes,'expenses' => $expenses-$taxes]);
        return view('monthly-report.show', ['totalIncome' => $income, 'taxes' => $taxes, 'retains' => $retains,  'totalPaid' => $grossIncome - $taxes, 'expenses' => $expenses - $taxes, 'equityAccounts' => $equityAccounts, 'totalEquity' => $totalEquity]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonthlyReport  $monthlyReport
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyReport $monthlyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonthlyReport  $monthlyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(MonthlyReport $monthlyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MonthlyReport  $monthlyReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlyReport $monthlyReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonthlyReport  $monthlyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyReport $monthlyReport)
    {
        //
    }
}
