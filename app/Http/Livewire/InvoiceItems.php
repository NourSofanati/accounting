<?php

namespace App\Http\Livewire;

use App\Models\Tax;
use Livewire\Component;

class InvoiceItems extends Component
{
    public $dueAmount;
    public $invoiceLines = [];
    public $draftInvoice;
    public $customers;
    public $cashAccounts;
    public $USDprice;
    public $currency;
    public function mount()
    {
        $this->dueAmount = 0;
        $this->invoiceLines = [['description' => '', 'rate' => 0, 'qty' => 1, 'total' => '']];
    }
    public function render()
    {
        $this->dueAmount = 0;
        foreach ($this->invoiceLines as $index => $line) {
            $this->invoiceLines[$index]['total'] = $line['rate'] * $line['qty'];
            $this->dueAmount += $this->invoiceLines[$index]['total'];
        }
        return view('livewire.invoice-items');
    }
    public function addLine()
    {
        $this->invoiceLines[] = ['description' => '', 'rate' => 0, 'qty' => 1, 'total' => ''];
    }
    public function removeLine($index)
    {
        unset($this->invoiceLines[$index]);
        $this->invoiceLines = array_values($this->invoiceLines);
    }
    public function addNewTax()
    {
        $this->taxItems[] = ['tax_id' => 1, 'tax_amount' => 0];
    }
}
