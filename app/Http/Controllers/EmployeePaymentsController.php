<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Entry;
use App\Models\ExpenseRecieptPayment;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeDetails;
use App\Models\HR\EmployeePayments;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EmployeePaymentsController extends Controller
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

    public function showpayment(EmployeeDetails $employee)
    {
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('hr.payments.create', ['employee' => $employee, 'parentAccounts' => $accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
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
            'account_id' => $employee->liability_account_id,
            'transaction_id' => $transaction->id,
            'currency_id' => $request->session()->get('currency_id'),
            'currency_value' => $request->currency_value,
        ]);
        EmployeePayments::create([
            'employee_id' => $employee->id,
            'currency_id' => $request->session()->get('currency_id'),
            'payment_date' => $request->date,
            'currency_value' => $request->currency_value,
            'amount' => $request->paidAmount,
            'transaction_id' => $transaction->id
        ]);
        return redirect()->route('employees.show', $employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\EmployeePayments  $employeePayments
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeePayments $employeePayments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\EmployeePayments  $employeePayments
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeePayments $employeePayments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HR\EmployeePayments  $employeePayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeePayments $employeePayments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\EmployeePayments  $employeePayments
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeePayments $employeePayments)
    {
        //
    }
}
