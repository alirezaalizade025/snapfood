<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $restaurant = [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->category->pluck('name')->implode(', '),
            'address' => $this->addressInfo()->get(['address', 'latitude', 'longitude'])->first(),
            'phone' => $this->phone,
            'is_open' => $this->status == 'active' ? true : false,
            'image' => isset($this->image) ? $this->image->path : null,
            'score' => round($this->score, 2),
        ];

        if ($restaurant['is_open'] == 'active') {
            $today = strtolower(now()->format('l'));
            if(now()->format('H:m') < $restaurant['schedule'][$today]['end'] || now()->format('H:m') > $restaurant['schedule'][$today]['start']){
                $restaurant['is_open'] = false;
            }
        }

        return $restaurant;
    }
}
