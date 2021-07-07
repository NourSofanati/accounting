<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\LogBook;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LogBookController extends Controller
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
        return view('logbook.create', ['accountTypes' => $accountTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $account = Account::find($request->account);
        $entries = $account->entries;
        $transactions = array();
        foreach ($entries as $entry) {
            array_push($transactions, $entry->transaction);
        }
        $transactions = (array_unique($transactions));
        return view('logbook.show', ['transactions' => $transactions, 'account' => $account]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogBook  $logBook
     * @return \Illuminate\Http\Response
     */
    public function show(LogBook $logBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogBook  $logBook
     * @return \Illuminate\Http\Response
     */
    public function edit(LogBook $logBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogBook  $logBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogBook $logBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogBook  $logBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogBook $logBook)
    {
        //
    }
}
