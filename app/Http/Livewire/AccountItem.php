<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Transaction;
use Livewire\Component;

class AccountItem extends Component
{
    public $item;
    public $depth;
    public $key;
    public $balance;
    public $usdBalance;
    public $currency;
    public $otherCurrency;
    public $hidden = true;
    public $parentId;
    public function mount()
    {
        $this->parentId = $this->item->parent_id;
        $this->key = $this->item->id;
        $this->balance = number_format($this->accountBalance($this->item), 2);
        $this->usdBalance = number_format($this->usdAccountBalance($this->item), 2);
        $this->currency = Currency::all()->where('id', session('currency_id'))->first();
        $this->otherCurrency = Currency::all()->where('id', '!=', session('currency_id'))->first();
    }


    public function render()
    {
        return view('livewire.account-item');
    }

    public function showItem(Account $account)
    {
        return redirect()->route('accounts.show', ['account' => $account]);
    }

    public function accountBalance($acc)
    {
        return $acc->balance();
    }

    public function usdAccountBalance($acc)
    {
        return $acc->usdBalance();
    }
}
