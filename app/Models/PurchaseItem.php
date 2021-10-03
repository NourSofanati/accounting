<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id', 'item_name', 'qty', 'discount', 'price'];
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
    public function attributes()
    {
        return $this->hasMany(PurchaseItemAttributes::class, 'purchase_item');
    }
}
