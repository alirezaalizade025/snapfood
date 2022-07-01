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
            'type' => $this->category->map(function ($item) {
            return $item->category->name;
        }
        )->implode(', '),
            'address' => $this->addressInfo()->get(['address', 'latitude', 'longitude'])->first(),
            // 'phone' => $this->phone, // TODO:uncomment phone
            'is_open' => $this->status == 'active' ? true : false,
            'image' => isset($this->image) ? $this->image->path : null,
            'score' => $this->carts->map(fn($cart) => $cart->comments->avg('score'))->avg(),
        ];

        return $restaurant;
    }
}
