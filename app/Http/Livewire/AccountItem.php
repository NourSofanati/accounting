<?php

namespace App\Http\Livewire;

use App\Models\Account;
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
    public function mount()
    {
        $this->balance = number_format($this->accountBalance($this->item), 2);
        $this->usdBalance = number_format($this->usdAccountBalance($this->item), 2);
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
