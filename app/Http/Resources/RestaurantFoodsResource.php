<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantFoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $food['id'] = $this->id;
        $food['title'] = $this->name;
        $food['price'] = $this->price;

        if ($this->discount != null && $this->discount != 0) {
            $food['off'] = ['label' => $this->discount . '%', 'factor' => number_format(1 - $this->discount / 100, 2)];
        }
        //if have this party discount ignored
        if ($this->thisParty != null) {
            $food['off'] = ['label' => $this->thisParty->name, 'factor' => number_format(1 - $this->thisParty->discount / 100, 2)];
        }

        $food['raw_material'] = $this->rawMaterials->implode('name', ', ');
        $food['image'] = $this->image ? $this->image->path : null;
        $food['category_id'] = $this->category_id;



        return $food;
    }
}
