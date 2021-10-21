<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PubStationResource extends JsonResource
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
            'address' => $this->address,
            'contact' => $this->contact_no,
            'coordinates' => $this->coordinates,
            'member' => $this->mm->member->name,
            'acronym' => $this->mm->member->acronym,
            'avatar' => $this->mm->member->avatar
        ];
    }
}
