<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionResource extends JsonResource
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
            'maintenance' => $this->maintenance,
            'expiration' => $this->expiry,
            'code' => $this->asset->asset_code,
            'name' => $this->asset->assetlocation->asset->name,
        ];
    }
}
