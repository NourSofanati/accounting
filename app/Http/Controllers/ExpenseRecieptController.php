<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Entry;
use App\Models\ExpenseCategory;
use App\Models\ExpenseReciept;
use App\Models\ExpenseRecieptItem;
use App\Models\ExpenseRecieptPayment;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ExpenseRecieptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expenses.index')->with('expenses', ExpenseReciept::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $draftexpenseReciept = ExpenseReciept::create();
        $cashAccounts = Account::all()->where('account_type', 1)->all();
        $vendors = Vendor::all();
        $categories = ExpenseCategory::all();
        return view('expenses.create')
            ->with('cashAccounts', $cashAccounts)
            ->with('vendors', $vendors)
            ->with('draftexpenseReciept', $draftexpenseReciept)
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reciept = ExpenseReciept::find($request->expenseRecieptNumber);
        $reciept->issueDate = $request->issueDate;
        $reciept->dueDate = $request->dueDate;
        $reciept->vendor_id = $request->vendor_id;
        $reciept->category_id = $request->category_id;
        $recieptTransaction = Transaction::create([
            'transaction_name' => 'Receipt ' . sprintf("%07d", $reciept->id),
            'transaction_date' => $reciept->issueDate,
        ]);
        $reciept->transaction_id = $recieptTransaction->id;
        $reciept->save();

        $currency = Currency::all()->where('id', session('currency_id'))->first();
        $otherCurrency = Currency::all()->where('id', '!=', session('currency_id'))->first();
        foreach ($request->entries as $index => $entry) {
            ExpenseRecieptItem::create([
                'reciept_id' => $reciept->id,
                'rate' => $entry['rate'],
                'qty' => $entry['qty'],
                'description' => $entry['description'],
                'currency_value' => $request->currency_value,
                'currency_id' => $request->session()->get('currency_id'),
            ]);
        }
        Entry::create([
            'cr' => $reciept->total(),
            'account_id' => $reciept->vendor->account_id,
            'transaction_id' => $recieptTransaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        Entry::create([
            'dr' => $reciept->total(),
            'account_id' => $reciept->vendor->loss_account_id,
            'transaction_id' => $recieptTransaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        if ($currency->code == 'USD') {
            $exchange_expense_account = Account::all()->where('name', 'مصاريف تحويل عملة')->first();
            Entry::create([
                'dr' => $reciept->total() * $request->currency_value,
                'account_id' => $reciept->vendor->loss_account_id,
                'transaction_id' => $recieptTransaction->id,
                'currency_id' => $otherCurrency->id,
                'currency_value' => $request->currency_value,
            ]);
            Entry::create([
                'cr' => $reciept->total() * $request->currency_value,
                'account_id' => $exchange_expense_account->id,
                'transaction_id' => $recieptTransaction->id,
                'currency_id' => $otherCurrency->id,
                'currency_value' => $request->currency_value,
            ]);
        }
        return redirect()->route('expenses.index');
    }



    public function addExpensePage(ExpenseReciept $reciept)
    {
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('expenses.payment')->with('reciept', $reciept)->with('parentAccounts', $accounts);
    }

    public function addExpense(Request $request, ExpenseReciept $reciept)
    {
        $transaction = Transaction::find($reciept->transaction_id);
        Entry::create([
            'cr' => $request->paidAmount,
            'account_id' => $request->designatedAccountId,
            'transaction_id' => $transaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        Entry::create([
            'dr' => $request->paidAmount,
            'account_id' => $reciept->vendor->account_id,
            'transaction_id' => $transaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        ExpenseRecieptPayment::create([
            'date' => $request->date,
            'amount' => $request->paidAmount,
            'reciept_id' => $reciept->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        return redirect()->route('expenses.show', $reciept);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function show($expenseReciept)
    {

        $dueAmount = 0;
        $expenseReciept = ExpenseReciept::findOrFail($expenseReciept);

        foreach ($expenseReciept->items as $item) {
            $dueAmount += ($item->qty * $item->rate);
        }
        return view('expenses.show')
            ->with('reciept', $expenseReciept)
            ->with('dueAmount', $dueAmount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseReciept $expenseReciept)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseReciept $expenseReciept)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseReciept  $expenseReciept
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseReciept $expenseReciept)
    {
        //
    }
}
