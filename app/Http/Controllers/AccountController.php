<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Currency;
use App\Models\HR\EmployeeDetails;
use App\Models\Invoice;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AccountController extends Controller
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
        $accountTypes = AccountType::all();
        return view('accounts.create')->with('accountTypes', $accountTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'parent_id' => 'required|numeric'
        ]);
        $parentAccount = Account::find($request->parent_id);

        Account::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'account_type' => $parentAccount->account_type,
        ]);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)

    {
        $vendor = Vendor::where('account_id', $account->id)->orWhere('loss_account_id', $account->id)->first();
        //$vendor = Vendor::where('account_id', $account->id)->orWhere('loss_account_id', $account->id)->first();
        $employee = EmployeeDetails::where('liability_account_id', $account->id)->orWhere('expense_account_id', $account->id)->first();
        return view('transactions.view')->with('account', $account)->with('vendor', $vendor)->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        return view('accounts.edit')->with('account', $account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $account->alias = $request->alias;
        $account->save();
        return redirect()->route('accounts.show', $account);
    }

    public function ledger(Account $account)
    {

        $currency = Currency::all()->where('id', session('currency_id'))->first();
        return view('accounts.ledger', ['account' => $account, 'currency' => $currency]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
