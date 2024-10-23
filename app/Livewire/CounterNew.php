<?php

namespace App\Livewire;

use Livewire\Component;

class CounterNew extends Component
{
    public $number=0;

    public function increment(){
        $this->number++;
    }
    public function decrement(){
        $this->number--;
    }
    
    public function render()
    {
        return view('livewire.counter-new');
    }
}
