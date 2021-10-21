<?php

namespace App\Http\Controllers;

use App\Models\AssetList;
use App\Models\AssetInfo;
use App\Models\AssetLogs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ListResource;
use App\Http\Resources\ActionResource;
use App\Http\Resources\ResultResource;
use App\Http\Resources\LogResource;
use App\Http\Requests\TrackerRequest;

class ListsController extends Controller
{
    public function index($id,$keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = AssetList::with('status')->where('assetlocation_id',$id)
        ->where(function ($query) use ($keyword){
            $query ->where('asset_code', 'LIKE', '%'.$keyword.'%')->orWhere('tracker_code', 'LIKE', '%'.$keyword.'%');
        })
        ->paginate(10);
        return ListResource::collection($data);
    }

    public function store(TrackerRequest $request){
        $data = AssetList::where('id',$request->input('id'))->first();
        ($request->input('trackercode') != 'n/a') ? $data->tracker_code = $request->input('trackercode') : '';
        $data->asset_code = $request->input('assetcode');
        $data->save();

        return new DefaultResource($data);
    } 

    public function coordinates($id){
        $data = AssetList::select('coordinates')->where('id',$id)->first();
        return $data;
    }

    public function search($keyword){
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  AssetList::with('assetlocation.location','assetlocation.asset')->with('status')->where('asset_code', 'LIKE', '%'.$keyword.'%')
        ->orWhereHas('assetlocation', function ($query) use ($keyword){
            $query->whereHas('asset', function ($query) use ($keyword){
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            });
        })
        ->paginate(10);
        return ResultResource::collection($data);
    }

    public function search2($location,$category,$status,$keyword){
        
        $member_id = \Auth::user()->member->mm->id;
        ($keyword == '-') ? $keyword = '' : $keyword;
        ($category == '-') ? $category = '' : $category;
        ($location == '-') ? $location = '' : $location;
        ($status == '-') ? $status = '' : $status;

        $query =  AssetList::query();
        $query->with('assetlocation.location','assetlocation.asset')->with('status','info');
        $query->where(function($q) use ($status,$category,$location,$member_id) {
            ($status != '') ? $q->where('status_id',$status) : '';
            $q->whereHas('assetlocation', function ($q) use ($category,$location,$member_id){
                ($location != '') ? $q->where('location_id',$location) : '';
                $q->whereHas('asset', function ($q) use ($category,$member_id){
                    ($category != '') ? $q->where('category_id',$category) : '';
                    $q->where('mm_id',$member_id);
                });
            });
         });
        $query->where(function($q) use ($keyword) {
            $q->where('asset_code','LIKE','%'.$keyword.'%');
            $q->orWhereHas('assetlocation', function ($q) use ($keyword){
                $q->whereHas('asset', function ($q) use ($keyword){
                    ($keyword != '') ? $q->where(function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', '%'.$keyword.'%');
                    }) : '';
                });
            });
        });
        $query->whereHas('info', function ($q) use ($keyword){
            
        });
        $data = $query->paginate(10);

        return ResultResource::collection($data);
    }

    public function status(Request $request)
    {   
        $id = $request->input('id');
        $remarks = $request->input('remarks');
        $status = $request->input('status');
        $data = AssetList::where('id',$id)->first();

        switch($request->input('type')){
            case 'Dispose':
                $is_avail = 0;
                $status = 4;
            break;
            case 'Maintenance': 
                switch($data->status_id){
                    case '3': 
                        $is_avail = 1;
                        $status = 2;
                        $remarks = 'Stop';
                    break;
                    default:
                        $is_avail = 0; 
                        $status = 3;
                        $remarks = 'Start';
                    ;
                }
            break;
            case 'Remarks':
                $is_avail = 0;
            break;
        }

        $data->is_available = $is_avail;
        (!empty($status)) ? $data->status_id = $status : $status = $data->status_id;
        
        if($data->save()){
            $this->storeLogs($id,$status,$remarks);
        }


        // if($data->status_id == 9){
        //     ($request->input('type') == "Remarks") ? $remarks = $request->input('remarks') : $remarks = 'Stop';
        // }
        // if($request->input('type') != null){
        //     if($request->input('type') == "Dispose"){
        //         $data->status_id = 4;
        //         $data->is_available = 0;
        //         $statid = 9;
        //     }else if($request->input('type') == "Maintenance"){
        //         $statid = 3;
        //         if($data->status_id == 8){
        //             $remarks = 'Stop';
        //             $data->status_id = 7;
        //             $data->is_available = 1;
        //         }else{
        //             $remarks = 'Start';
        //             $data->status_id = 8;
        //             $data->is_available = 0;
        //         }
        //     }else{
        //         $statid = 1;
        //     }
        // }else{
        //     $data->status_id = $request->input('status');
        // } 
        
        // $data->save();

        // ($statid == 8 || $statid == 10) ? $c =AssetLogs::where('asset_id',$request->input('id'))->where('is_completed',0)->count() : $c = 0;

        // $logs = new AssetLogs;
        // $logs->status_id = $statid;
        // $logs->remarks = $remarks;
        // $logs->asset_id = $request->input('id');
        // $logs->save();


        // ($c > 0)  ? $logs = AssetLogs::where('asset_id',$request->input('id'))->orderBy('created_at','DESC')->first() : $logs = new AssetLogs;
        // ($c > 0) ? '' : $logs->status_id = $statid;
        // ($remarks != null || $remarks != '') ? ($c > 0) ? '' : $logs->remarks = $remarks : '';
        // ($c > 0) ? $logs->is_completed = 1 : '';
        // ($c > 0) ? '' : $logs->asset_id = $request->input('id');
        // $logs->save();
            
        return new ResultResource($data);
    }

    public function update(Request $request){

        $ids = $request->input('ids');
        $type = $request->input('type');
        $date = $request->input('date');

        foreach($ids as $id){
            $count = AssetInfo::where('asset_id',$id)->count();

            ($count == 1) ? $data = AssetInfo::where('asset_id',$id)->first() : $data = new AssetInfo;
            ($count == 0) ? $data->asset_id = $id : '';
            ($type == 'Maintenance') ? $data->maintenance = $date : $data->expiry = $date;
            $data->save();
        }

        return true;
    }

    public function check($type){

        $date = \Carbon\Carbon::now()->addDays(20)->format( 'Y-m-d' );

        if($type == 'M'){  
            $data = AssetInfo::with('asset:id,assetlocation_id,asset_code','asset.assetlocation:id,asset_id','asset.assetlocation.asset:id,name')
            ->where('maintenance', '<=' ,$date)
            ->orderBy('maintenance','ASC')
            ->paginate(5);
        }else{
            $data = AssetInfo::with('asset:id,assetlocation_id,asset_code','asset.assetlocation:id,asset_id','asset.assetlocation.asset:id,name')
            ->where('expiry', '<=' ,$date)
            ->orderBy('expiry','ASC')
            ->paginate(5);
        }

        return ActionResource::collection($data);
    }

    public function logs($id){
        $data = AssetLogs::where('asset_id',$id)->orderBy('created_at','DESC')->paginate(5);
        return LogResource::collection($data);
    }

    public function storeLogs($id,$status,$remarks){

        $logs = new AssetLogs;
        $logs->status_id = ($remarks == 'Stop') ? 3 : $status;
        $logs->remarks = $remarks;
        $logs->asset_id = $id;
        $logs->save();
    }

    public function logsAll(){
        $member_id = \Auth::user()->member->mm->id;
        $data = AssetLogs::whereHas('asset', function ($q) use ($member_id){
            $q->whereHas('assetlocation', function ($q) use ($member_id){
                $q->whereHas('asset', function ($q) use ($member_id){
                    $q->where('mm_id',$member_id);
                });
            });
        })->orderBy('created_at','DESC')
        ->paginate(5);
        return LogResource::collection($data);
    }
   
}
