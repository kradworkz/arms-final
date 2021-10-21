<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetList;
use App\Models\AssetInfo;
use App\Models\AssetLocation;
use App\Models\Dropdown;
use App\Models\MemberAsset;
use Illuminate\Http\Request;
use App\Services\StoreImage2;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ViewResource;
use App\Http\Resources\AssetResource;
use App\Http\Resources\ListResource;
use App\Http\Requests\AssetRequest;

class AssetController extends Controller
{
    public function index(){
        return view('user_member.assetslist');
    }

    public function page(){
        return view('user_member.view');
    }

    public function search(){
        return view('user_member.search');
    }

    public function index1($keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  AssetLocation::with('asset')->with('location')
        ->whereHas('asset', function ($query) use ($keyword,$member_id){
            $query->where('mm_id',$member_id)->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhereHas('location', function ($query) use ($keyword,$member_id){
            $query->where('mm_id',$member_id)->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->paginate(5);
        return AssetResource::collection($data);
    }

    public function store(StoreImage2 $strmg, AssetRequest $request){
        \DB::transaction(function () use ($request,$strmg){
            $member_id = \Auth::user()->member->mm->id;

            $data = new Asset; 
            $data->name =  ucwords(strtolower($request->input('name')));
            $data->category_id = $request->input('category');
            $data->mm_id = $member_id;
            $data->image = ($request->input('avatar') != '') ? $strmg->strmg($request->input('avatar'),strtolower($request->input('name'))) : 'default.jpeg';

            if($data->save()){
                $this->locations($request);
                return new DefaultResource($data);
            }
        });
    }

    public function locations(Request $request){
        $id = ($request->input('id') == '') ? \DB::getPdo()->lastInsertId() : $request->input('id');
        $lists = $request->input('lists'); 

        foreach($lists as $list)
        {   
            $location = new AssetLocation;
            $location->quantity = $list['quantity'];
            $location->location_id = $list['location']['id'];
            $location->asset_id = $id;
            if($location->save()){
                if($request->input('trackable')){
                   $this->lists($location->id,$list['quantity']);
                }
            }
        }
        return true;
    }

    public function lists($id,$quantity){
        $count = AssetList::where('assetlocation_id',$id)->count();
        $status = Dropdown::select('id')->where('classification','Status')->where('name','Operational')->first();
        $count = $count + 1;
        for($x = 0; $x<$quantity; $x++){
            $data = new AssetList;
            $data->asset_code = \Auth::user()->member->mm->member->acronym.'-'.$id.'-'.str_pad(($count), 6, '0', STR_PAD_LEFT); ;
            $data->assetlocation_id = $id;
            $data->status_id = $status->id;
            $data->save();

            $info = new AssetInfo;
            $info->asset_id = $data->id;
            $info->save();

            $count ++;
        }
        return true;
    }

    public function updateQuantity(Request $request){
        $data = AssetLocation::where('id',$request->input('id'))->first();
        $data->quantity = $data->quantity + $request->input('quantity');
        if($data->save()){
            if($request->input('trackable')){
               $this->lists($request->input('id'),$request->input('quantity'));
            }
        }
        return new DefaultResource($data);
    }

    public function view($id){
        $data = AssetLocation::with('asset')->where('id',$id)->first();
        return new ViewResource($data);
    }

    public function status(Request $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        $data->status_id = $request->input('status');
        ($request->input('status') == 2) ? $data->is_available = 1 :  $data->is_available = 0;

        if($data->save()){
            if($request->input('agency') != ''){
                $borrowed = new MemberAsset;
                $borrowed->borrowed_to = \Auth::user()->member->mm->id;
                $borrowed->borrowed_by = $request->input('agency');
                $borrowed->status_id = 10;
                $borrowed->asset_id = $request->input('id');
                $borrowed->save();
            }
            return new ListResource($data);
        }
    }


}
