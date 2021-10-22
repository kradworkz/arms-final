<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Models\DeviceData;
use App\Models\AssetList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\PacketResource;
use App\Http\Resources\DeviceResource;
use App\Events\AssetLocation;
use App\Events\SlewsEvent;
use App\Events\NotifyEvent;

class ChirpstackController extends Controller
{
    public function index(){
        header("Content-type: application/json");
        $json = file_get_contents("php://input");

        $obj = json_decode($json);
        $binary = base64_decode($obj->devEUI);
        $devicename = $obj->deviceName;
        $tracker_id = bin2hex($binary);
        $decoded = json_encode($obj->objectJSON);
        $a = \json_decode($decoded);
        $aa = \json_decode($a);


        switch($devicename){
            case 'Node1Slews':
                $this->slews($aa,$tracker_id);
            break;
            case 'MDD':
                $this->arms($aa,$tracker_id);
            break;
        }

        // if($devicename == "Node1Slews"){
            
        //     broadcast(new SlewsEvent($aa));
        // }else{
        //     $date = new \DateTime;
        //     $date->modify('-1 minutes');
        //     $formatted_date = $date->format('Y-m-d H:i:s');
        //     $device = DeviceData::where('code',$tracker_id)->where('status',$aa->status)->where('created_at','>=', $formatted_date)->count();
            
        //     if($device == 0){
        //         $wew = new DeviceData;
        //         $wew->coordinates = json_encode($aa->gps);
        //         $wew->status = $aa->status;
        //         $wew->code = $tracker_id;
        //         $wew->save();

        //         broadcast(new AssetLocation($wew));

        //         $data = AssetList::where('tracker_code',$tracker_id)->first();
        //         if(!empty($data)){
        //             $data->coordinates =  json_encode($aa->gps);
        //             $data->save();
        //         }

        //         return true;
                
        //     }else{
        //         return true;
        //     }
        // }
    }

    public function slews($aa,$tracker_id)
    {
        $device = Device::where('code',$tracker_id)->first();

        if($aa->Gyro < .30){
            $settings = [
                'color' => '',
                'type' => 'error-circle',
                'date' => date('M d, Y g:i a', strtotime(now())) 
            ];
        }else if($aa->Gyro > .30 && $aa->Gyro < 1){
            $settings = [
                'color' => 'info',
                'type' => 'error-circle',
                'date' => date('M d, Y g:i a', strtotime(now())) 
            ];
        }else if($aa->Gyro > 1 && $aa->Gyro < 2){
            $settings = [
                'color' => 'warning',
                'type' => 'error-circle',
                'date' => date('M d, Y g:i a', strtotime(now())) 
            ];
        }else{
            $settings = [
                'color' => 'danger',
                'type' => 'error-circle',
                'date' => date('M d, Y g:i a', strtotime(now())) 
            ];
        }

        $arr = [
            'device' => new DeviceResource($device),
            'aa' => $aa,
            'setting' => $settings
        ];
        broadcast(new SlewsEvent($arr));
    }

    public function arms($aa,$tracker_id){
        $date = new \DateTime;
        $date->modify('-1 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $device = DeviceData::where('code',$tracker_id)->where('status',$aa->status)->where('created_at','>=', $formatted_date)->count();
            
        if($device == 0){
            $wew = new DeviceData;
            $wew->coordinates = json_encode($aa->gps);
            $wew->status = $aa->status;
            $wew->code = $tracker_id;
            $wew->groupid = 1;
            $wew->save();

            broadcast(new AssetLocation($wew));

            $data = AssetList::where('tracker_code',$tracker_id)->first();
            if(!empty($data)){
                $data->coordinates =  json_encode($aa->gps);
                $data->save();
            }
            return true;
        }else{
            return true;
        }
    }
}
