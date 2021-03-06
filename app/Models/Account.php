<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Account extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'name',
        'account_type',
        'parent_id',
    ];
    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }
    public function grandparent()
    {
        if (!$this->parent) {
            return $this;
        } else {
            $grandparent = $this->parent->grandparent();
            return $grandparent;
        }
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
        if ($this->account_type == AccountType::IS_EQUITY || $this->account_type == AccountType::IS_LIABILITY || $this->account_type == AccountType::IS_INCOME) {
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

        return $this->account_type == AccountType::IS_ASSET && $balance != 0 ? $balance : $balance * -1;
    }

    public function dateLedgerCredit($fromDate, $toDate)
    {
        $cr = 0;
        foreach ($this->entries as $entry) {
            if (($fromDate) <= $entry->transaction->transaction_date && ($toDate) >= $entry->transaction->transaction_date)
                $cr += $entry['currency_id'] == session('currency_id') ? $entry['cr'] : 0;
        }
        return $cr;
    }

    public function dateLedgerDebit($fromDate, $toDate)
    {
        $dr = 0;
        foreach ($this->entries as $entry) {
            if ($entry->transaction->transaction_date >= ($fromDate)  && ($toDate) >= $entry->transaction->transaction_date)
                $dr += $entry['currency_id'] == session('currency_id') ? $entry['dr'] : 0;
        }
        return $dr;
    }

    public function dateLedgerBalance($fromDate, $toDate)
    {
        $balance = $this->dateLedgerDebit($fromDate, $toDate) - $this->dateLedgerCredit($fromDate, $toDate);

        return $this->account_type == AccountType::IS_ASSET && $balance != 0 ? $balance : $balance * -1;
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
        // $currency = Currency::all()->where('id', session('currency_id'))->first();
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == session('currency_id')) {
                if (session('currency_id') == Currency::IS_SYP) {
                    $sum += $this->grandparent()->name == '??????????' || $this->grandparent()->name == '???????????????? ????????????????' ? $entry['cr'] :  $entry['cr'] / $entry['currency_value'];
                } else {
                    $sum += $this->grandparent()->name == '??????????' || $this->grandparent()->name == '???????????????? ????????????????' ? $entry['cr'] :  $entry['cr'] * $entry['currency_value'];
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
        // $currency = Currency::all()->where('id', session('currency_id'))->first();
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == session('currency_id')) {
                if (session('currency_id') == Currency::IS_SYP) {
                    $sum += $this->grandparent()->name == '??????????' || $this->grandparent()->name == '???????????????? ????????????????' ? $entry['dr'] : $entry['dr'] / $entry['currency_value'];
                } else {
                    $sum += $this->grandparent()->name == '??????????' || $this->grandparent()->name == '???????????????? ????????????????' ? $entry['dr'] : $entry['dr'] * $entry['currency_value'];
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
        // $currency = Currency::all()->where('id', session('currency_id'))->first();
        if ($this->grandparent()->name == '??????????' || $this->grandparent()->name == '???????????????? ????????????????') {
            $latestRate = CurrencyRate::orderBy('created_at', 'desc')->first();
            if (isset($latestRate) && $latestRate->currency_rate == 0) {
                $latestRate->currency_rate = 1;
            }
            if (!isset($latestRate)) {
                $latestRate = CurrencyRate::create(['currency_rate' => 1]);
            }


            if (session('currency_id') == Currency::IS_USD) {
                $sum *= $latestRate ? $latestRate->currency_rate : 1;
            } else {
                $sum /= $latestRate ? $latestRate->currency_rate : 1;
            }
        }
        if ($this->account_type == AccountType::IS_EQUITY || $this->account_type == AccountType::IS_LIABILITY || $this->account_type == AccountType::IS_INCOME) {
            return $sum * -1;
        } else {
            return $sum;
        }
    }

    public function _USD_Credit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        // $currency = Currency::all()->where('code', 'USD')->first();
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == Currency::IS_USD) {
                $sum +=  $entry['cr'] / $entry['currency_value'];
            }
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->_USD_Credit();
            }
        }
        return $sum;
    }
    public function _USD_Debit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        // $currency = Currency::all()->where('code', 'USD')->first();
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == Currency::IS_USD) {
                $sum +=  $entry['dr'];
            }
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->_USD_Debit();
            }
        }
        return $sum;
    }

    public function _USD_Balance()
    {
        $sum = 0;
        if ($this == null) {
            return 0;
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->_USD_Debit() - $leaf->_USD_Credit();
            }
        } else {
            $sum = $this->_USD_Debit() - $this->_USD_Credit();
        }
        if ($this->account_type == AccountType::IS_EQUITY || $this->account_type == AccountType::IS_LIABILITY || $this->account_type == AccountType::IS_INCOME) {
            return $sum * -1;
        } else {
            return $sum;
        }
    }
    public function _SYP_Credit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        // $currency = Currency::all()->where('code', 'SYP')->first();
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == Currency::IS_SYP) {
                $sum +=  $entry['cr'] / $entry['currency_value'];
            }
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->_SYP_Credit();
            }
        }
        return $sum;
    }
    public function _SYP_Debit()
    {
        if ($this == null) {
            return 0;
        }
        $sum = 0;
        // $currency = Currency::all()->where('code', 'SYP')->first();
        foreach ($this->entries as $entry) {
            if ($entry['currency_id'] == Currency::IS_SYP) {
                $sum +=  $entry['dr'];
            }
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->_SYP_Debit();
            }
        }
        return $sum;
    }

    public function _SYP_Balance()
    {
        $sum = 0;
        if ($this == null) {
            return 0;
        }
        if ($this->children->count()) {
            foreach ($this->children as $leaf) {
                $sum += $leaf->_SYP_Debit() - $leaf->_SYP_Credit();
            }
        } else {
            $sum = $this->_SYP_Debit() - $this->_SYP_Credit();
        }
        if ($this->account_type == AccountType::IS_EQUITY || $this->account_type == AccountType::IS_LIABILITY || $this->account_type == AccountType::IS_INCOME) {
            return $sum * -1;
        } else {
            return $sum;
        }
    }
}
