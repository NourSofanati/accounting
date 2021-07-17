<?php

namespace App\Http\Livewire;

use App\Models\FixedAsset;
use Livewire\Component;

class ExpenseRecieptItems extends Component
{
    public $vendors;
    public $cashAccounts;
    public $categories;
    public $FixedAssets;
    public $expenseRecieptLines;
    public $draftexpenseReciept;
    public $dueAmount;
    public $currency;
    public FixedAsset $selectedAsset;
    public $expenses = [];
    public $selectedExpense;
    public function mount()
    {
        $this->expenseRecieptLines = array();
        $this->FixedAssets = FixedAsset::all();
        if ($this->FixedAssets->count() > 0)
            $this->selectedAsset = $this->FixedAssets[0];
        else {
            alert()->error('يجب إضافة أصل أولاً');
            return redirect()->route('purchases.create');
        }
    }

    public function changeEvent($event)
    {
        $this->selectedAsset = FixedAsset::find($event);
        $this->expenses = $this->selectedAsset->expensesGroup->expenses;
    }

    public function render()
    {

        $this->expenses = @$this->selectedAsset->expensesGroup->expenses;
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
