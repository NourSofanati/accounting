<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Purchase extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = ['date', 'vendor_id', 'transaction_id', 'currency_value', 'type', 'invertory_id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->price * $item->qty;
        }
        return $total;
    }
    public function payments()
    {
        return $this->hasMany(PurchasePayment::class, 'purchase_id');
    }

    public function totalPaid()
    {
        $total = 0;
        foreach ($this->payments as $payment) {
            $total += $payment->amount;
        }
        return $total;
    }
    public function totalDue()
    {
        return $this->total() - $this->totalPaid();
    }
}
