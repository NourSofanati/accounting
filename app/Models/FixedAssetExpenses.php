<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetExpenses extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'group_id', 'account_id'];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
