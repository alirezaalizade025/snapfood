<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class SelectSchedule extends Component
{
    use Actions;
    public $schedule = [
        1 => ['open_time' => '08:00', 'close_time' => '21:00'],
        2 => ['open_time' => '08:00', 'close_time' => '21:00'],
        3 => ['open_time' => '08:00', 'close_time' => '21:00'],
        4 => ['open_time' => '08:00', 'close_time' => '21:00'],
        5 => ['open_time' => '08:00', 'close_time' => '21:00'],
        6 => ['open_time' => '08:00', 'close_time' => '21:00'],
        7 => ['open_time' => '08:00', 'close_time' => '21:00'],
    ];

    public function emitSchedule()
    {
        $this->notification()->send([
            'title'       => 'Set Schedule!',
            'description' => 'Schedule Set Successfully',
            'icon'        => 'success'
        ]);
        $this->emit('schedule', $this->schedule);
    }

    public function render()
    {  
        return view('livewire.select-schedule');
    }
}
