<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChooseLocation extends Component
{
    public $showingModal = false;

    public $listeners = [
        'hideMe' => 'hideModal',
        'showChooseLocation' => 'showModal',
    ];
    public function showModal()
    {
        $this->showingModal = true;
        $this->resetErrorBag();
    }
    public function hideModal()
    {
        $this->showingModal = false;
    }
    public function render()
    {
        return view('livewire.choose-location');
    }
}
