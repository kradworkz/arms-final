<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PubAssetsResource extends JsonResource
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
            'code' => $this->asset_code,
            'availability' => $this->is_available,
            'name' => $this->assetlocation->asset->name,
            'image' => $this->assetlocation->asset->image,
            'category' => $this->assetlocation->asset->category->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
