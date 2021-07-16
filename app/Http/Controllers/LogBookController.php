<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\LogBook;
use App\Models\Transaction;
use Carbon\Carbon;
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
        return view('logbook.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = Carbon::today()->format('d/m/Y');

        $accountTypes = AccountType::all();
        return view('logbook.create', ['accountTypes' => $accountTypes, 'today' => $today]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transactions = [];
        //dd($request->fromDate);
        if ($request->toDate) {
            $transactions = Transaction::whereBetween('transaction_date', [$request->fromDate, $request->toDate])->get();
        } else {
            $transactions = Transaction::where('transaction_date', $request->fromDate)->get();
        }
        
        //$fromData;

        return view('logbook.show', ['transactions' => $transactions,'fromDate' => $request->fromDate,'toDate' => $request->toDate]);
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
