<?php

namespace App\Http\Livewire;

use App\Models\AccountType;
use App\Models\Currency;
use App\Models\Entry;
use App\Models\Transaction;
use Illuminate\Http\Client\Request;
use Livewire\Component;

class EditEntries extends Component
{
    public $transaction;
    public $accountTypes;
    public $entries;
    public $totalDr;
    public $totalCr;
    public $totalDrUSD;
    public $totalCrUSD;
    public $diff;
    public $newTransaction;
    public $lastValue = 0;
    public $USDprice;
    public $currency;
    protected $rules = [
        
        'entries.*.cr' => ['decimal'],
        'entries.*.dr' => ['decimal'],
        
    ];
    public function mount()
    {
        
        $this->currency = Currency::where('id', session('currency_id'))->first();
        $this->accountTypes = AccountType::all();
        $this->lastValue = $this->USDprice;
        //$this->entries = [['account_id' => 0, 'cr' => 0, 'dr' => 0, 'currency_value' => $this->USDprice], ['account_id' => 0, 'cr' => 0, 'dr' => 0, 'currency_value' => $this->USDprice]];
        $this->diff = 0;
        $this->newTransaction = Transaction::create();
    }

    public function addEntry()
    {
        $this->entries[] = ['account_id' => 0, 'cr' => 0, 'dr' => 0, 'currency_value' => $this->lastValue];
    }

    public function removeEntry($index)
    {
        unset($this->entries[$index]);
        $this->entries = array_values($this->entries);
    }

    public function changeLastValue($index)
    {
        $this->lastValue = $this->entries[$index]['currency_value'];
    }

    public function render()
    {
        $this->totalDr = 0;
        $this->totalCr = 0;
        $this->totalDrUSD = 0;
        $this->totalCrUSD = 0;
        foreach ($this->entries as $index => $entry) {
            if ($entry['dr'] < 0) {
                $this->entries[$index]['dr'] = 0;
                $entry['dr'] = 0;
            }
            if ($entry['cr'] < 0) {
                $this->entries[$index]['cr'] = 0;
                $entry['cr'] = 0;
            }
            $this->totalDr += (float)$entry['dr'];
            $this->totalCr += (float)$entry['cr'];
            $this->totalDrUSD += (float)$entry['dr'] / $entry['currency_value'];
            $this->totalCrUSD += (float)$entry['cr'] / $entry['currency_value'];
        }
        $this->changeLastValue(count($this->entries) - 1);
        $this->diff = abs($this->totalDr - $this->totalCr);
        return view('livewire.entries');
    }
    public function cancelTransaction()
    {
        //Transaction::destroy($this->newTransaction->id);
        return redirect()->route('dashboard');
    }
}
