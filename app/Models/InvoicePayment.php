<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id', 'amount', 'date', 'currency_id', 'currency_value'
    ];
    public function amount()
    {
        return $this->amount;
    }
}
