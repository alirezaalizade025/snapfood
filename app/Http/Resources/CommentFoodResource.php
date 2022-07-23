<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author' => ['name' => $this->user->name],
            'foods' => $this->cart->foods->pluck('name'),
            'created_at' => $this->created_at->diffForHumans(),
            'score' => $this->score,
            'content' => $this->content,
            'answer' => trim($this->answer)
        ];
    }
}
