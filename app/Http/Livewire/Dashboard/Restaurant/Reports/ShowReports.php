<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Reports;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShowReports extends Component
{

    public function fetchData()
    {
        $this->total_income = Cart::where('restaurant_id', auth()->user()->restaurant->id)
        ->where('status', '4')
        ->select(DB::raw('SUM(total_price) as total_income'))
        ->get()->first()->total_income;


        return Cart::
            where('restaurant_id', auth()->user()->restaurant->id)
            ->where('status', '4')
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
