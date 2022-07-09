<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return
        [
            'id' => $this->id,
            'restaurant' => [
                'title' => $this->restaurant->title,
                'image' => $this->restaurant->image ? $this->restaurant->image->path : null,
            ],

            'foods' => $this->cartFood->map(function ($food) {
            $food = [
                    'id' => $food->food->id,
                    'title' => $food->food->name,
                    'restaurant' => $food->food->restaurant->title,
                    'count' => $food->quantity,
                    'price' => $food->price,

                    'off' => $food->food->food_party_id ? ['label' => $food->food->foodParty->name, 'factor' => number_format(1 - $food->food->foodParty->discount / 100, 2)] : ($food->food->discount ? ['label' => $food->food->discount . '%', 'factor' => number_format(1 - $food->food->discount / 100, 2)] : null),

                    
                ];
                $food['final_price'] = $food['price'] * (isset($food['off']) ? $food['off']['factor'] : 1);
                return $food;
        })->values(),
        ];
    }
}
