<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRecieptItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'reciept_id', 'rate', 'qty', 'description', 'name'
    ];
    public function total()
    {
        return $this->qty * $this->rate;
    }
}
