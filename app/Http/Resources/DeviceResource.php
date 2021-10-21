<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'station' => $this->station,
            'coordinates' => $this->coordinates,
            'datalogger' => $this->data_logger,
            'remarks' => $this->remarks,
            'type' => $this->type,
            'status' => $this->status,
            'code' => $this->code,
            'avatar' => $this->status->color.'.png',
            'municipality' => $this->municipality,
            'province' => $this->municipality->province,
            'address' => $this->municipality->name.', '.$this->municipality->province->name
        ];
    }
}
