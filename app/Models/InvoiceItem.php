<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id', 'rate', 'qty', 'description', 'name'
    ];
    public function total()
    {
        return $this->qty * $this->rate;
    }
}
