<?php

namespace App\Http\Livewire;

use App\Models\Tax;
use Livewire\Component;

class InvoiceTax extends Component
{
    public $taxItems = [];
    public $taxCategories;
    public function render()
    {
        $this->taxCategories = Tax::all();

        return view('livewire.invoice-tax');
    }
    public function addNewTax()
    {
        $this->taxItems[] = ['tax_id' => 1, 'tax_amount' => 0];
    }
}
