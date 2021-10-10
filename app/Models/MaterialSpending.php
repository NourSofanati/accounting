<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSpending extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'qty_spent', 'account_spent_on_id','date'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function accountSpentOn()
    {
        return $this->belongsTo(Account::class, 'account_spent_on_id');
    }
}
