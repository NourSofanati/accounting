<?php

namespace App\Models\HR;

use App\Models\EmployeeLiability;
use App\Models\Invertory;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate',
        'startDate',
        'gender',
        'payday',
        'monthlySalary',
        'liability_account_id',
        'expense_account_id',
        'position_id',
        'invertory_id',
    ];

    public function fullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function invertory()
    {
        return $this->belongsTo(Invertory::class, 'invertory_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function picture()
    {
        return $this->hasOne(EmployeePicture::class, 'employee_id');
    }
    public function liabilities()
    {
        return $this->hasMany(EmployeeLiability::class, 'employee_id');
    }

    public function payments()
    {
        return $this->hasMany(EmployeePayments::class, 'employee_id');
    }

    public function totalLiabilities()
    {
        $total = 0;
        foreach ($this->liabilities as $liability) {
            $total += $liability->amount;
        }
        return $total;
    }
    public function totalPayments()
    {
        $total = 0;
        foreach ($this->payments as $payment) {
            $total += $payment->amount;
        }
        return $total;
    }
    public function totalDue()
    {
        return $this->totalLiabilities() - $this->totalPayments();
    }
}
