<?php

namespace App\Http\Livewire\Dashboard\Restaurant\MyRestaurantShow;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\WeekSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SelectSchedule extends Component
{
    use Actions;
    public $schedule = [
        1 => ['start' => '08:00', 'end' => '21:00'],
        2 => ['start' => '08:00', 'end' => '21:00'],
        3 => ['start' => '08:00', 'end' => '21:00'],
        4 => ['start' => '08:00', 'end' => '21:00'],
        5 => ['start' => '08:00', 'end' => '21:00'],
        6 => ['start' => '08:00', 'end' => '21:00'],
        7 => ['start' => '08:00', 'end' => '21:00'],
    ];

    public function emitSchedule()
    {
        $this->notification()->send([
            'title' => 'Set Schedule!',
            'description' => 'Schedule Set Successfully',
            'icon' => 'success'
        ]);
        $this->emit('schedule', $this->schedule);
    }

    public function fetchData()
    {
        if (auth()->user()->restaurant) {
            $request = Request::create('/api/restaurants/' . auth()->user()->restaurant->id . '/dashboard', 'GET');
            $request->headers->set('Accept', 'application/json');
            $request->headers->set('Authorization', 'Bearer ' . auth()->user()->api_token);

            $response = Route::dispatch($request);

            if ($response->status() == 200) {
                $schedule = collect(json_decode($response->getContent())->schedule)
                    ->map(function ($item) {
                    return $item ? collect($item)->toArray() : ['start' => '', 'end' => ''];
                })
                    ->toArray();
                $days = ['saturday' => 1, 'sunday' => 2, 'monday' => 3, 'tuesday' => 4, 'wednesday' => 5, 'thursday' => 6, 'friday' => 7];
                foreach ($schedule as $key => $value) {
                    $this->schedule[$days[$key]] = $value;
                }
                $this->emit('refreshComponent');
            }
            else {
            // TODO:show message
            }
        }
    }

    public function render()
    {
        $this->fetchData();
        return view('livewire.dashboard.restaurant.my-restaurant-show.select-schedule');
    }
}
