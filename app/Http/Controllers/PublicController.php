<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\AssetList;
use App\Models\AssetLocation;
use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Http\Resources\ListResource;
use App\Http\Resources\PubResource;
use App\Http\Resources\PubAssetsResource;
use App\Http\Resources\DropdownResource;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DeviceResource;

class PublicController extends Controller
{
    public function index($id,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
    
        $query = AssetList::query();
        $query = $query->with('status')->with(['assetlocation.asset','assetlocation.location'])
        ->where('coordinates','!=',NULL)
        ->where('asset_code', 'LIKE', '%'.$keyword.'%');
        if($id != '-'){
            $query = $query->whereHas('assetlocation', function ($query) use ($id){
                $query->whereHas('asset', function ($query) use ($id){
                    $query->where('category_id',$id);
                });
            });
        }
        $data = $query->get();

        return ListResource::collection($data);
    }

    public function assets($id,$keyword){
        $query = AssetList::query();
        $query = $query->with('status')->with(['assetlocation:id,asset_id','assetlocation.asset:id,name,image,category_id','assetlocation.asset.category:id,name'])
        ->where('asset_code', 'LIKE', '%'.$keyword.'%')
        ->whereHas('assetlocation', function ($query) use ($id){
            $query->whereHas('location', function ($query) use ($id){
                $query->where('location_id',$id);
            });
        });
        $data = $query->paginate(10);

        return PubAssetsResource::collection($data);
    }   

    public function status(){
        $data = Dropdown::where('type','Asset')->where('classification','Status')->get();
        return PubResource::collection($data);
    }

    public function category(){
        $data = Dropdown::where('classification','Category')->get();
        return DropdownResource::collection($data);
    }

    public function devices($id,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
    
        $query = Device::query();
        $query = $query->with('status')
        ->where('coordinates','!=',NULL);
        if($id != '-'){
            $query->where('type_id',$id);
        }
        $query->where('station', 'LIKE', '%'.$keyword.'%');
        $data = $query->get();

        return DeviceResource::collection($data);
    }
}
