<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemAttributes extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_item', 'key', 'value'];
}
