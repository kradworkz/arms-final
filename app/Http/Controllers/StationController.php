<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\LocationResource;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\PubStationResource;

class StationController extends Controller
{
    public function index(){
        return view('user_member.station');
    }

    public function lists($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $member_id = \Auth::user()->member->mm->id;
        $data = Location::where('mm_id',$member_id)
        ->where('name', 'LIKE', '%'.$keyword.'%')
        ->orderBy('id','DESC')
        ->paginate(5);
        return LocationResource::collection($data);
    }

    public function list(){
        $data = Location::where('mm_id',\Auth::user()->member->mm->id)->get();
        return LocationResource::collection($data);
    }

    public function stations(){
        $data = Location::with('mm:id,member_id,municipality_id','mm.member:id,name,acronym,avatar,type')->where('status',1)->get();
        return PubStationResource::collection($data);
    }

    public function store(LocationRequest $request){
        $member_id = \Auth::user()->member->mm->id;
       
        $data = ($request->input('editable')) ? Location::findOrFail($request->input('id')) : new Location;
        $data->name = ucwords(strtolower($request->input('name')));
        $data->address = ucwords(strtolower($request->input('address')));
        $data->contact_no = $request->input('contact_no');
        $data->coordinates = $request->input('coordinates');
        $data->mm_id = $member_id; 
        $data->save();

        return new DefaultResource($data);
    }


}
