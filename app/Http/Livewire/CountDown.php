<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class CountDown extends Component
{
    public $expires_at;

    public function mount()
    {
        $this->expires_at = Carbon::parse($this->expires_at);
    }
    public function render()
    {
        return view('livewire.count-down');
    }
}
