<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ExchangeItems extends Component
{
    public $USDprice;
    public $currencies;
    public $currency;
    public $otherCurrency;
    public $cashAccounts;
    public function mount()
    {
        $this->currency = $this->currencies->where('id', session('currency_id'))->first();
        $this->otherCurrency = $this->currencies->where('id', '!=', session('currency_id'))->first();
    }

    public function render()
    {
        return view('livewire.exchange-items');
    }
}
