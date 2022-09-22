<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            '_id' => $this->id,
            'title' => $this->title,
            'genre' => $this->genre->name,
            'numberInStock' => $this->numberInStock,
            'dailyRentalRate' => $this->dailyRentalRate,
            'is_liked' => $this->is_liked
        ];
    }
}
