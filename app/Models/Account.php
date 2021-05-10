<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'account_type',
        'parent_id',
    ];
    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type');
    }
    public function credit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        foreach ($this->entries as $entry) {
            $sum += $entry['currency_id'] == session('currency_id') ? $entry['cr'] : 0;
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->credit();
            }
        }
        return $sum;
    }
    public function debit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        foreach ($this->entries as $entry) {
            $sum += $entry['currency_id'] == session('currency_id') ? $entry['dr'] : 0;
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->debit();
            }
        }
        return $sum;
    }

    public function balance()
    {
        $sum = 0;
        if ($this == null) {
            return 0;
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->debit() - $leaf->credit();
            }
        } else {
            $sum = $this->debit() - $this->credit();
        }
        if ($this->accountType->name == 'حقوق الملكية' || $this->accountType->name == 'التزامات' || $this->accountType->name == 'دخل') {
            return $sum * -1;
        } else {
            return $sum;
        }
    }

    public function ledgerCredit()
    {
        $cr = 0;
        foreach ($this->entries as $entry) {
            $cr += $entry['currency_id'] == session('currency_id') ? $entry['cr'] : 0;
        }
        return $cr;
    }

    public function ledgerDebit()
    {
        $dr = 0;
        foreach ($this->entries as $entry) {
            $dr += $entry['currency_id'] == session('currency_id') ? $entry['dr'] : 0;
        }
        return $dr;
    }

    public function ledgerBalance()
    {
        $balance = $this->ledgerDebit() - $this->ledgerCredit();

        return $this->accountType->name == 'أصول' && $balance != 0 ? $balance : $balance * -1;
    }

    public function entries()
    {
        return $this->hasMany(Entry::class, 'account_id');
    }

    public function usdCredit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == session('currency_id')) {
                if (session('currency_id') == 2) {
                    $sum +=  $entry['cr'] / $entry['currency_value'];
                } else {
                    $sum +=  $entry['cr'] * $entry['currency_value'];
                }
            }
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->usdCredit();
            }
        }
        return $sum;
    }
    public function usdDebit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == session('currency_id')) {
                if (session('currency_id') == 2) {
                    $sum +=  $entry['dr'] / $entry['currency_value'];
                } else {
                    $sum +=  $entry['dr'] * $entry['currency_value'];
                }
            }
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->usdDebit();
            }
        }
        return $sum;
    }

    public function usdBalance()
    {
        $sum = 0;
        if ($this == null) {
            return 0;
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->usdDebit() - $leaf->usdCredit();
            }
        } else {
            $sum = $this->usdDebit() - $this->usdCredit();
        }
        if ($this->accountType->name == 'حقوق الملكية' || $this->accountType->name == 'التزامات' || $this->accountType->name == 'دخل') {
            return $sum * -1;
        } else {
            return $sum;
        }
    }
}
