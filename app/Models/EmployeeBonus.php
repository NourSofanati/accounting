<?php

namespace App\Models;

use App\Models\HR\EmployeeDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBonus extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'date', 'bonus_amount', 'currency_value', 'description', 'transaction_id'];
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
