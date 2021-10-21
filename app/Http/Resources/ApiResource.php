<?php

namespace App\Http\Resources;

use Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $level = $this->deviceStatusBatteryLevel;

        if($level == 0){
            $color = 'info';
            $status = 'car-battery';
        }else if($level  >= 80 ){
            $color = 'success';
            $status = 'battery-charging';
           
        }else if($level >= 50){
            $color = 'warning';
            $status = 'battery-low';
        }else{
            $color = 'danger';
            $status = 'battery-full';
        }

        return [
            'name' => $this->name,
            'code' => $this->devEUI,
            'date' =>  date('M d, Y g:i:s a', strtotime($this->lastSeenAt)),
            'lastseen' => Carbon\Carbon::parse($this->lastSeenAt)->diffForHumans(),
            'battery' => $level,
            'battery_color' => $color,
            'battery_status' => $status,
        ];
    }
}
