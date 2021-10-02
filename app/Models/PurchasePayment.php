<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id', 'payment_account', 'currency_value', 'amount', 'date'];

    public function paymentAccount()
    {
        return $this->belongsTo(Account::class, 'payment_account');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
