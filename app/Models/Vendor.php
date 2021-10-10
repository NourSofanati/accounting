<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Vendor extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'name', 'account_id', 'loss_account_id', 'phone', 'address', 'id'
    ];
    public function Account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function LossAccount()
    {
        return $this->belongsTo(Account::class, 'loss_account_id');
    }
    public function ExpenseReciept()
    {
        return $this->hasMany(ExpenseReciept::class, 'vendor_id');
    }
}
