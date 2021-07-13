<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetExpenseGroup extends Model
{
    use HasFactory;
    protected $fillable = ['asset_id'];
    public function expenses()
    {
        return $this->hasMany(FixedAssetExpenses::class, 'group_id');
    }
}
