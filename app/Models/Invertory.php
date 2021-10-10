<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invertory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'parent_id', 'account_id'
    ];
    public function children()
    {
        return $this->hasMany(Invertory::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Invertory::class, 'parent_id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function assets()
    {
        return $this->hasMany(FixedAsset::class, 'invertory_id');
    }

    public function getNameAndPathAttribute()
    {
        $name = $this->name;
        if ($this->parent_id) {
            return  $this->parent->name_and_path . ' / ' . $name;
        } else {
            return $name;
        }
    }
}
