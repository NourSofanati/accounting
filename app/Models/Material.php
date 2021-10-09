<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = ['invertory_id', 'category_id', 'purchase_item_id', 'price', 'qty'];
    public function invertory()
    {
        return $this->belongsTo(Invertory::class, 'invertory_id');
    }
    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }
    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class, 'purchase_item_id');
    }
    public function getTotalPriceAttribute()
    {
        return $this->qty * $this->price;
    }
    public function getRemainingPriceAttribute()
    {
        return $this->total_price - ($this->total_spent * $this->price);
    }

    public function getRemainingQtyAttribute()
    {
        return $this->qty - $this->total_spent;
    }


    public function getAllQtyAttribute()
    {
        return $this->qty;
    }

    public function spendings()
    {
        return $this->hasMany(MaterialSpending::class, 'material_id');
    }

    public function getTotalSpentAttribute()
    {
        $total = 0;
        foreach ($this->spendings as $spending) {
            $total += $spending->qty_spent;
        }
        return $total;
    }



    public function getAvailableQtyAttribute()
    {
        $available = $this->qty - $this->total_spent;
        return $available;
    }
}
