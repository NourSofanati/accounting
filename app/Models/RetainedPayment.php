<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetainedPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id', 'amount', 'paid'
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
