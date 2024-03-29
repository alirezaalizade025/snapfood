<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Reports;

use Carbon\Carbon;
use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShowReports extends Component
{
    public $normalPicker;
    public $startDate;
    public $endDate;
    public $search;

    public function fetchData()
    {
        $where = [];
        if ($this->startDate) {
            $where[] = ['created_at', '>=', Carbon::parse($this->startDate)->format('Y-m-d H:i:s')];
        }
        if ($this->endDate) {
            $where[] = ['created_at', '<=', Carbon::parse($this->endDate)->format('Y-m-d H:i:s')];
        }
        if ($this->search) {
            $where[] = ['id', $this->search];
        }

        $this->total_income = Cart::where('restaurant_id', auth()->user()->restaurant->id)
            ->where('status', '4')
            ->with('cartFood')
            ->get()->map(function($cart) {
                return $cart->cartFood->map(function($food) {
                    return $food->price;
                });
            })->flatten()->sum();



        return Cart::
            where('restaurant_id', auth()->user()->restaurant->id)
            ->where('status', '4')
            ->where($where)
            ->with('cartFood')
            ->paginate(20);
    }
    public function render()
    {
        return view('livewire.dashboard.restaurant.reports.show-reports', [
            'reports' => $this->fetchData()
        ]);
    }
}
