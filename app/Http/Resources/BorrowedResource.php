<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowedResource extends JsonResource
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
            'name' => ($this->by->member->type == "LGU") ? $this->municipality->name : $this->by->member->name,
            'created_at' => $this->created_at,
            'returnd_at' => $this->updated_at
        ];
    }
}
