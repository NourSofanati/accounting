<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FixedAssetExpenses extends Component
{

    public $expenses;

    public function mount()
    {
        $this->expenses = array();
    }

    public function render()
    {
        return view('livewire.fixed-asset-expenses');
    }
    public function addEntry()
    {
        $this->expenses[] = ['expense_name' => ""];
    }

    public function removeEntry($index)
    {
        unset($this->expenses[$index]);
        $this->expenses = array_values($this->expenses);
    }
}
