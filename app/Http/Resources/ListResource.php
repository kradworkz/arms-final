<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
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
            'asset' => $this->asset_code,
            'tracker' => ($this->tracker_code == null) ? 'n/a' : $this->tracker_code,
            'coordinates' => ($this->coordinates == null) ? $this->assetlocation->location->coordinates : $this->coordinates,
            'status' => $this->status,
            'avatar' => $this->status->color.'.png',
            'created_at' => $this->created_at,
            'name' => $this->assetlocation->asset->name,
            'image' => $this->assetlocation->asset->image,
            'location' => $this->assetlocation->location->name,
            'address' => $this->assetlocation->location->address,
            'borrowed' => ($this->status->name == "Borrowed") ? BorrowedResource::collection($this->borrowed) : ''
        ];
    }
}
