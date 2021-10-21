<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'asset_id' => $this->asset->id,
            'name' => $this->asset->name,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'available' => $this->available(),
            'location' => $this->location->name,
            // 'storage_address' => $this->storage->address,
            // 'storage_contact' => $this->storage->contact_no,
            // 'brand' => ($this->information != null) ? $this->information->brand : 'n/a',
            // 'serial_no' => ($this->information != null) ? $this->information->serial_no : 'n/a',
            // 'model' => ($this->information != null) ? $this->information->model : 'n/a',
            // 'description' => ($this->information != null) ? $this->information->description : 'n/a',
            // 'purchases' => $this->purchases
        ];
    }
}
