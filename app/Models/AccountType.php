<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'account_type')->where('parent_id', null);
    }

    public function ledgerAccounts()
    {
        return $this->hasMany(Account::class, 'account_type');
    }
    public function hasEntries()
    {

        foreach ($this->accounts as  $value) {
            if ($value->entries->count() > 0) return true;
        }
        return false;
    }

    public function balance()
    {
        $totalBalance = 0;
        foreach ($this->accounts as $account) {
            $totalBalance += $account->balance();
        }
        return $totalBalance;
    }
    public function usdBalance()
    {
        $totalBalance = 0;
        foreach ($this->accounts as $account) {
            $totalBalance += $account->usdBalance();
        }
        return $totalBalance;
    }
}
