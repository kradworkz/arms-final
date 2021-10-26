<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DatalogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $event = json_decode($this->event);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'event' => $event,
            'x' => $event->setting->date,
            'y' => $event->aa->Gyro
        ];
    }
}
