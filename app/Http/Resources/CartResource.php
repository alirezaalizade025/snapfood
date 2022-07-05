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

            'foods' => $this->cartFood->map(fn($food) => [
        'id' => $food->food->id,
        'title' => $food->food->name,
        'restaurant' => $food->food->restaurant->title,
        'count' => $food->quantity,
        'price' => $food->price,
        ])->values(),
        ];
    }
}
