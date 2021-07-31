<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\EmployeeBonus;
use App\Models\Entry;
use App\Models\HR\EmployeeDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EmployeeBonusController extends Controller
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
    public function create(EmployeeDetails $employeeDetails)
    {

        return view('hr.bonus.create')->with('employeeDetails', $employeeDetails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $employee = EmployeeDetails::find($request->employee_id);
        $transaction = Transaction::create([
            'transaction_name' => 'سلفة للموظف ' . $employee->fullName(),
            'transaction_date' => $request->date,
            'currency_id' => 1,
        ]);
        Entry::create([
            'cr' => $request->paidAmount,
            'account_id' => $request->designatedAccountId,
            'transaction_id' => $transaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        Entry::create([
            'dr' => $request->paidAmount,
            'account_id' => $employee->expense_account_id,
            'transaction_id' => $transaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);

        EmployeeBonus::create([
            'description' => $request->description,
            'employee_id' => $employee->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
            'date' => $request->date,
            'bonus_amount' => $request->paidAmount,
            'transaction_id' => $transaction->id,
        ]);

        return redirect()->route('employees.show', $employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeBonus  $employeeBonus
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeBonus $employeeBonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeBonus  $employeeBonus
     * @return \Illuminate\Http\Response
     */
    public function edit($employeeDetails)
    {
        $employeeDetails = EmployeeDetails::findOrFail($employeeDetails);
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('hr.bonus.create', ['employee' => $employeeDetails, 'parentAccounts' => $accounts])->with('employeeDetails', $employeeDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeBonus  $employeeBonus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeBonus $employeeBonus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeBonus  $employeeBonus
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeBonus $employeeBonus)
    {
        //
    }
}
