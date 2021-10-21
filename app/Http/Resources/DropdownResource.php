<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DropdownResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color,
            'counts' => ($this->classification == 'Category' || $this->classification == 'Device') ? $this->count() :  $this->lists() ,
            'percentage' => ($this->classification == 'Category') ? $this->aw() :  $this->aw() ,
        ];
    }
}
