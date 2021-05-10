<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseReciept extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'attachment_id', 'transaction_id', 'category_id', 'issueDate', 'dueDate', 'vendor_id'
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function items()
    {
        return $this->hasMany(ExpenseRecieptItem::class, 'reciept_id');
    }

    public function payments()
    {
        return $this->hasMany(ExpenseRecieptPayment::class, 'reciept_id');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->total();
        }
        return $total;
    }

    public function totalPaid()
    {

        $total = 0;
        if ($this->payments->count() > 0) {
            foreach ($this->payments as $item) {
                $total += $item->amount();
            }
        }
        return $total;
    }


    public function totalDue()
    {
        return $this->total() - $this->totalPaid();
    }
}
