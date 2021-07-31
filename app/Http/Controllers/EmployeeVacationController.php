<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\EmployeeVacation;
use App\Models\Entry;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EmployeeVacationController extends Controller
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
        $sypCurrency = Currency::where('code', 'SYP')->first();
        $vacation = EmployeeVacation::create([
            'employee_id' => $request->employee_id,
            'paid' => $request->paid == "true",
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'currency_value' => $request->currency_value,
            'description' => $request->description,
        ]);
        if ($request->paid == "false") {
            $employee = EmployeeDetails::findOrFail($request->employee_id);
            if (!$employee) {
                alert('لم يتم العثور على الموظف');
                return redirect()->back();
            }
            $transaction = Transaction::create([
                'transaction_name' => 'خصم إجازة',
                'transaction_date' => $vacation->toDate,
                'currency_id' => $sypCurrency->id,
                'currency_value' => $request->currency_value,
            ]);
            $crEntry = Entry::create([
                'transaction_id' => $transaction->id,
                'currency_value' => $request->currency_value,
                'currency_id' => $sypCurrency->id,
                'cr' => $request->amount,
                'account_id' => $employee->expense_account_id,
            ]);
            $drEntry = Entry::create([  
                'transaction_id' => $transaction->id,
                'currency_value' => $request->currency_value,
                'currency_id' => $sypCurrency->id,
                'dr' => $request->amount,
                'account_id' => $employee->liability_account_id,
            ]);
            $vacation->transaction_id = $transaction->id;
            $vacation->save();
        }
        toast()->success('تم تسجيل ساعات اجازة للموظف');
        return redirect()->route('employees.show', $request->employee_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeVacation  $employeeVacation
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeVacation $employeeVacation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeVacation  $employeeVacation
     * @return \Illuminate\Http\Response
     */
    public function edit($employeeDetails)
    {
        $employeeDetails = EmployeeDetails::find($employeeDetails)->first();
        $cA = Account::all()->where('name', 'النقد')->first();
        $accounts = Account::all()->where('parent_id', $cA->id);
        return view('hr.vacations.create', ['employee' => $employeeDetails, 'parentAccounts' => $accounts])->with('employeeDetails', $employeeDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeVacation  $employeeVacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeVacation $employeeVacation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeVacation  $employeeVacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeVacation $employeeVacation)
    {
        //
    }
}
