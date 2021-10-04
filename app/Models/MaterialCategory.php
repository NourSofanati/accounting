<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'unit'];
    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }
    public function getTotalQtyAttribute(bool $withUnit = false)
    {
        $totalQty = 0;
        foreach ($this->materials as $material) {
            $totalQty += $material->available_qty;
        }
        return $withUnit ? $totalQty . ' ' . $this->unit : $totalQty;
    }
}
