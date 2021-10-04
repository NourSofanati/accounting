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

    public function getAllQtyAttribute(bool $withUnit = false)
    {
        return $withUnit ? $this->qty . ' ' . $this->category->unit : $this->qty;
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

    public function getAvailableQtyAttribute(bool $withUnit = false)
    {
        $available = $this->qty - $this->total_spent;
        return $withUnit ? $available . ' ' . $this->category->unit : $available;
    }
}
