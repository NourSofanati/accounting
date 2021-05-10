<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePicture extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id', 'uri'
    ];
}
