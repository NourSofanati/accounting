<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_name', 'transaction_date', 'description', 'currency_id'
    ];
    public function entries()
    {
        return $this->hasMany(Entry::class, 'transaction_id');
    }
}
