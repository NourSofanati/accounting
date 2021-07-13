<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRecieptPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'reciept_id', 'amount', 'date', 'currency_id', 'currency_value', 'paid_from', 'refunded'
    ];
    public function amount()
    {
        return $this->amount;
    }
}
