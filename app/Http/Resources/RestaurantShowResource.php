<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $days = ['saturday' => 1, 'sunday' => 2, 'monday' => 3, 'tuesday' => 4, 'wednesday' => 5, 'thursday' => 6, 'friday' => 7];

        $restaurant = [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->category->map(function ($item) {
            return $item->category->name;
        })->implode(', '),
            'address' => $this->addressInfo()->get(['address', 'latitude', 'longitude'])->first(),
            'phone' => $this->phone,
            'is_open' => $this->status == 'active' ? true : false,
            'image' => isset($this->image) ? $this->image->path : null,
            'score' => $this->carts->map(fn($cart) => $cart->comments->avg('score'))->avg(),
            'comment_count' => $this->carts->map(fn($cart) => $cart->comments->count())->sum(),
            'schedule' => $this->weekSchedules->keyBy('day')->map(function ($item) {
            return [
            'start' => $item->open_time,
            'end' => $item->close_time
            ];
        })
        ];

        // for add null if no schedule for that day
        collect($days)->diffKeys($restaurant['schedule'])->each(function ($item, $key) use ($restaurant) {
            $restaurant['schedule'][$key] = null;
        });
        // sort by day order in week schedule
        $restaurant['schedule'] = $restaurant['schedule']->sortBy(fn($val, $key) => $days[$key]);
        return $restaurant;
    }
}
