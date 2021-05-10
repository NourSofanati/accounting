<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Entry;
use Livewire\Component;

class TransactionEntryTableRow extends Component
{
    public $account;

    public function render()
    {
        return view('livewire.transaction-entry-table-row');
    }
    public function getEntries()
    {
        
    }
}
