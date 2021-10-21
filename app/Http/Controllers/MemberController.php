<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberMunicipality;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{
    public function index(){
        return view('user_admin.member');
    }

    public function index1(){
        return view('user_admin.lgu');
    }

    public function lists($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  Member::where('name','LIKE','%'.$keyword.'%')->paginate(10);
        return DefaultResource::collection($data);
    }

    public function list()
    {
        $data =  Member::get();
        return DefaultResource::collection($data);
    }

    public function lgu($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data =  MemberMunicipality::with('member')->with('municipality')
        ->whereHas('municipality',function ($query) use ($keyword) {
            $query->where('member_id',1)->where('name', 'LIKE', '%'.$keyword.'%');
        })->paginate(10);
        return DefaultResource::collection($data);
    }

    public function store(StoreImage $strmg,MemberRequest $request){
        if($request->editable){
            $data = Member::where('id',$request->id)->update($request->except('img','editable'));
            $strmg->strmg($request,$request->id);
        }else{
            $data = Member::create($request->all());
            $strmg->strmg($request,$data->id);
        }
        return new DefaultResource(Member::findOrFail(($request->editable) ? $request->id : $data->id));
    }
}
