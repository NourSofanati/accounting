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
    public $sign;
    // public $otherCurrency;
    public $hidden = true;
    public $parentId;
    public $accountType;
    public function mount()
    {
        $this->parentId = $this->item->parent_id;
        $this->key = $this->item->id;
        $this->balance = number_format($this->accountBalance($this->item), 2);
        $this->usdBalance = number_format($this->usdAccountBalance($this->item), 2);
        $this->sign = session('currency_id') == 1 ? 'ل.س' : '$';
        switch($this->item->account_type) {
            case 1:
                $this->accountType = 'أصول';
                break;
            case 2:
                $this->accountType = 'إلتزامات';
                break;
            case 3:
                $this->accountType = 'ملكية';
                break;
            case 4:
                $this->accountType = 'دخل';
                break;
            case 5:
                $this->accountType = 'نفقات';
                break;
        }
        // $this->otherCurrency = Currency::all()->where('id', '!=', session('currency_id'))->first();
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
