<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EmployeeAchievmentItem extends Component
{

    public $achievments = [];

    public function mount()
    {
    }
    public function render()
    {
        return view('livewire.employee-achievment-item');
    }

    public function addEntry()
    {
        $this->achievments[] = ['achievment' => "", 'type' => "",];
    }

    public function removeEntry($index)
    {
        unset($this->achievments[$index]);
        $this->achievments = array_values($this->achievments);
    }
}
