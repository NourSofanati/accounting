<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeVacation extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id', 'description', 'transaction_id', 'fromDate', 'toDate', 'paid'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
