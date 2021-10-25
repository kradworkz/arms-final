<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceLog;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DatalogResource;
use App\Http\Resources\DeviceResource;
use App\Http\Requests\DeviceRequest;

class DeviceController extends Controller
{
    public function index(){
        return view('user_admin.device');
    }

    public function index1(){
        return view('user_admin.tracker');
    }

    public function lists($keyword,$status,$type){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $query = Device::query();
        ($status != '-') ? $query->where('status_id',$status) : '';
        ($type != '-') ? $query->where('type_id',$type) : '';
        $query->where('station', 'LIKE', '%'.$keyword.'%');
        $data = $query->orderBy('created_at','DESC')->paginate(5);
        return DeviceResource::collection($data);
    }

    public function store(DeviceRequest $request){

        if($request->editable){
            $data = Device::findOrFail($request->id);
            $data->update($request->except('editable'));
        }else{
            $data = Device::create($request->all());
        }

        return new DeviceResource($data);
    }

    
    public function logs($code){
        $data = DeviceLog::where('code',$code)->orderBy('created_at','DESC')->get();
        return DatalogResource::collection($data);
    }
}
