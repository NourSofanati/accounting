<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Attachment;
use App\Models\AttachmentGroup;
use App\Models\EmployeeAchivement;
use App\Models\EmployeeLiability;
use App\Models\Entry;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeDetails;
use App\Models\HR\EmployeePicture;
use App\Models\Invertory;
use App\Models\Position;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function checkLiabilities()
    {
        $employees = EmployeeDetails::all();
        foreach ($employees as $employee) {
            $now = Carbon::now();
            $payday = Carbon::create($now->year, $now->month, $employee->payday);
            $lastMonthPayDay = Carbon::create($now->year, $now->month, $employee->payday);
            $lastMonthPayDay->subMonth();
            // $now->gte($payday) if true transfer money to liabilities
            //dd($now->gte($payday), $now->gte($lastMonthPayDay), $payday, $lastMonthPayDay, $now);
            if ($now->gte($payday)) {
                $found = Transaction::all()
                    ->where('transaction_date', $payday->format('Y-m-d'))
                    ->where('transaction_name', 'راتب ' . $employee->fullName())->first();
                if (!$found) {
                    $transaction = Transaction::create([
                        'transaction_name' => 'راتب ' . $employee->fullName(),
                        'transaction_date' => $payday,
                        'currency_id' => 1,
                    ]);
                    Entry::create([
                        'currency_value' => 3600,
                        'currency_id' => 1,
                        'cr' => $employee->monthlySalary,
                        'account_id' => $employee->liability_account_id,
                        'transaction_id' => $transaction->id,
                    ]);
                    Entry::create([
                        'currency_value' => 3600,
                        'currency_id' => 1,
                        'dr' => $employee->monthlySalary,
                        'account_id' => $employee->expense_account_id,
                        'transaction_id' => $transaction->id,
                    ]);
                    EmployeeLiability::create([
                        'employee_id' => $employee->id,
                        'transaction_id' => $transaction->id,
                        'amount' =>  $employee->monthlySalary,
                    ]);
                }
            } else if ($now->gte($lastMonthPayDay)) {
                $found = Transaction::all()
                    ->where('transaction_date', $lastMonthPayDay->format('Y-m-d'))
                    ->where('transaction_name', 'راتب ' . $employee->fullName())->first();
                if (!$found) {
                    $transaction = Transaction::create([
                        'transaction_name' => 'راتب ' . $employee->fullName(),
                        'transaction_date' => $lastMonthPayDay,
                        'currency_id' => 1,
                    ]);
                    Entry::create([
                        'currency_value' => 3600,
                        'currency_id' => 1,
                        'cr' => $employee->monthlySalary,
                        'account_id' => $employee->liability_account_id,
                        'transaction_id' => $transaction->id,
                    ]);
                    Entry::create([
                        'currency_value' => 3600,
                        'currency_id' => 1,
                        'dr' => $employee->monthlySalary,
                        'account_id' => $employee->expense_account_id,
                        'transaction_id' => $transaction->id,
                    ]);
                    EmployeeLiability::create([
                        'amount' => $employee->monthlySalary,
                        'employee_id' => $employee->id,
                        'transaction_id' => $transaction->id,
                        'amount' =>  $employee->monthlySalary,
                    ]);
                }
            }
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkLiabilities();
        $hasPositions = Position::all()->count();
        return view('hr.index', ['employees' => EmployeeDetails::all(), 'hasPositions' => $hasPositions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.create', ['positions' => Position::all(), 'invertories' => Invertory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'birthDate' => 'required|date',
            'startDate' => 'required|date',
            'payday' => 'required',
            'gender' => 'required',
            'monthlySalary' => 'required',
            'position_id' => 'required|integer',
            'invertory_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $fullName = $request->firstName . ' ' . $request->lastName;

        $liabilities = Account::all()->where('name', 'رواتب موظفين')->where('account_type', 2)->first();
        $expenses = Account::all()->where('name', 'رواتب موظفين')->where('account_type', 5)->first();


        $employee_liability_account = Account::create([
            'name' => $fullName,
            'account_type' => 2,
            'parent_id' => $liabilities->id,
        ]);
        $employee_expense_account = Account::create([
            'name' => $fullName,
            'account_type' => 5,
            'parent_id' => $expenses->id,
        ]);

        $attachmentGroup = AttachmentGroup::create([]);
        $employee_details = EmployeeDetails::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'birthDate' => $request->birthDate,
            'startDate' => $request->startDate,
            'gender' => $request->gender,
            'payday' => $request->payday,
            'monthlySalary' => $request->monthlySalary,
            'liability_account_id' => $employee_liability_account->id,
            'expense_account_id' => $employee_expense_account->id,
            'position_id' => $request->position_id,
            'invertory_id' => $request->invertory_id,
            'attachment_group_id' => $attachmentGroup->id,
        ]);

        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');
            $picture = EmployeePicture::create([
                'employee_id' => $employee_details->id,
                'uri' => $imageName,
            ]);
        }
        foreach ($request->achievments as $index => $achievment) {
            EmployeeAchivement::create([
                'type' => $achievment['type'],
                'achievment' => $achievment['achievment'],
                'employee_id' => $employee_details['id'],
            ]);
        }

        $files = ($request->file('attachment'));
        if ($request->hasFile('attachment')) {
            $fileNameArr = [];
            foreach ($files as $file) {
                $uri = time() . '-' . $file->getClientOriginalName();
                $fileNameArr[] = $uri;
                $file->move(public_path('attachments'), $uri);
                Attachment::create(['url' => $uri, 'group_id' => $employee_details->attachment_group_id, 'name' => $file->getclientOriginalName()]);
            }
        }
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeDetails $employee)
    {
        return view('hr.show', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeDetails $employee)
    {
        return view('hr.edit', ['e' => $employee, 'positions' => Position::all(), 'invertories' => Invertory::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HR\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeDetails $employee)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'birthDate' => 'required|date',
            'startDate' => 'required|date',
            'payday' => 'required',
            'gender' => 'required',
            'monthlySalary' => 'required',
            'position_id' => 'required|integer',
            'invertory_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $employee->firstName =  $request->firstName;
        $employee->lastName =  $request->lastName;
        $employee->birthDate =  $request->birthDate;
        $employee->startDate =  $request->startDate;
        $employee->gender =  $request->gender;
        $employee->payday =  $request->payday;
        $employee->monthlySalary =  $request->monthlySalary;
        $employee->position_id =  $request->position_id;
        $employee->invertory_id =  $request->invertory_id;
        $employee->save();
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');
            $employee->picture->uri = $imageName;
            $employee->picture->save();
        }
        $files = ($request->file('attachment'));
        if ($request->hasFile('attachment')) {
            $fileNameArr = [];
            foreach ($files as $file) {
                $uri = time() . '-' . $file->getClientOriginalName();
                $fileNameArr[] = $uri;
                $file->move(public_path('attachments'), $uri);
                Attachment::create(['url' => $uri, 'group_id' => $employee->attachment_group_id, 'name' => $file->getclientOriginalName()]);
            }
        }


        return redirect()->route('employees.show', $employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
