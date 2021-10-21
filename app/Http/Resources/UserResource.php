<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'status' => $this->status,
            'type' => $this->type,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'member' => $this->member->mm->member,
            'created_at' => $this->created_at,
            'municipality' => $this->member->mm->municipality,
            'province' => $this->member->mm->municipality->province,
            'updated_at' => $this->updated_at
        ];
    }
}
