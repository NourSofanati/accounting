<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'customer_id', 'transaction_id', 'status', 'dueDate', 'issueDate', 'currency_id', 'currency_value', 'attachment_group_id', 'invoice_month', 'invoice_date'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }
    public function taxes()
    {
        return $this->hasMany(InvoiceTax::class, 'invoice_id');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->total();
        }
        return $total;
    }

    public function totalSyp()
    {
        return $this->total() * $this->currency_value;
    }
    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id');
    }
    public function retains()
    {
        return $this->hasMany(RetainedPayment::class, 'invoice_id');
    }
    public function totalRetains()
    {
        $total = 0;
        foreach ($this->retains as $key) {
            if ($key->paid != true)
                $total += $key->amount;
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

    public function totalTaxes()
    {
        $total = 0;
        foreach ($this->taxes as $key) {
            $total += $key->amount;
        }
        return $total;
    }

    public function totalDue()
    {
        return ($this->total() - $this->totalPaid()) - $this->totalRetains();
    }
    public function totalDueSyp()
    {
        return ($this->totalSyp() - $this->totalPaid()) - $this->totalRetains();
    }
}
