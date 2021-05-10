<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Entry;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = AccountType::all();
        return view('journal.create')->with('accountTypes', $accountTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->entries);
        $parentTransaction = Transaction::find($request->transaction_id);
        $parentTransaction->transaction_name = $request->name;
        $parentTransaction->transaction_date = $request->date;
        $parentTransaction->description = $request->description;
        $parentTransaction->currency_id = session('currency_id');
        $parentTransaction->save();
        foreach ($request->entries as $entry) {
            if (isset($entry['dr']))
                Entry::create([
                    'dr' => $entry['dr'],
                    'account_id' => $entry['account_id'],
                    'transaction_id' => $request->transaction_id,
                    'currency_value' => $entry['currency_value'],
                    'currency_id' => session('currency_id'),
                ]);
            else
                Entry::create([
                    'cr' => $entry['cr'],
                    'account_id' => $entry['account_id'],
                    'transaction_id' => $request->transaction_id,
                    'currency_value' => $entry['currency_value'],
                    'currency_id' => session('currency_id'),
                ]);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        $arr = explode("/", $request->session()->previousUrl());
        $account = Account::find($arr[count($arr) - 1]);
        return view('transactions.show')->with('transaction', $transaction)->with('account', $account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
