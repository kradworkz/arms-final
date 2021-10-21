<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'asset_code' => $this->asset_code,
            'tracker_code' => ($this->tracker_code == null) ? '' : $this->tracker_code,
            'coordinates' => $this->coordinates,
            'name' => $this->assetlocation->asset->name,
            'image' => $this->assetlocation->asset->image,
            'location' => $this->assetlocation->location->name,
            'address' => $this->assetlocation->location->address,
            'category' => $this->assetlocation->asset->category->name,
            'maintenance' => ($this->info->maintenance == 'Jan 01, 1970') ? 'n/a' : $this->info->maintenance,
            'expiry' => ($this->info->expiry == 'Jan 01, 1970') ? 'n/a' : $this->info->expiry,
            'status' => $this->status,
            'availability' => ($this->is_available == 1) ? 'Available' : 'Not Available',
            'created_at' => $this->created_at
        ];
    }
}
