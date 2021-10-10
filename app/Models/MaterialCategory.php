<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MaterialCategory extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = ['name', 'unit'];
    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }

    public function getTotalQtyAttribute()
    {
        $totalQty = 0;
        foreach ($this->materials as $material) {
            $totalQty += $material->available_qty;
        }
        return $totalQty;
    }
    public function getTotalRemainingPriceAttribute()
    {
        $totalPrice = 0;
        foreach ($this->materials as $material) {
            $totalPrice += $material->remaining_price;
        }
        return $totalPrice;
    }
}
