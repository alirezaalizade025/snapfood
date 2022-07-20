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
        1 => ['start' => '', 'end' => ''],
        2 => ['start' => '', 'end' => ''],
        3 => ['start' => '', 'end' => ''],
        4 => ['start' => '', 'end' => ''],
        5 => ['start' => '', 'end' => ''],
        6 => ['start' => '', 'end' => ''],
        7 => ['start' => '', 'end' => ''],
    ];

    public function sendScheduleToForm()
    {
        $this->emit('scheduleChange', $this->schedule);
    }

    public function mount()
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
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = json_decode($response->getContent())->msg
                );
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard.restaurant.my-restaurant-show.select-schedule');
    }
}
