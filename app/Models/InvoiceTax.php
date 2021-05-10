<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTax extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id', 'tax_id', 'amount'
    ];
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
