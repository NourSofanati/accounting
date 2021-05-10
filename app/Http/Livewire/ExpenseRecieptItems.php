<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ExpenseRecieptItems extends Component
{
    public $vendors;
    public $cashAccounts;
    public $categories;
    public $expenseRecieptLines;
    public $draftexpenseReciept;
    public $dueAmount;
    public function mount()
    {
        $this->expenseRecieptLines = array();
    }

    public function render()
    {
        $this->dueAmount = 0;
        foreach ($this->expenseRecieptLines as $index => $line) {
            $this->expenseRecieptLines[$index]['total'] = $line['rate'] * $line['qty'];
            $this->dueAmount += $this->expenseRecieptLines[$index]['total'];
        }
        return view('livewire.expense-reciept-items');
    }
    public function addLine()
    {
        $this->expenseRecieptLines[] = ['description' => '', 'rate' => 0, 'qty' => 1, 'total' => ''];
    }
    public function removeLine($index)
    {
        unset($this->expenseRecieptLines[$index]);
        $this->expenseRecieptLines = array_values($this->expenseRecieptLines);
    }
}
