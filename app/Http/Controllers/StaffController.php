<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberMunicipality;
use Illuminate\Http\Request;
use App\Services\StoreImage;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\StaffRequest;

class StaffController extends Controller
{
    public function index(){
        return view('user_admin.staff');
    }

    public function lists($keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $users =  User::where('type','Member')
        ->where('name', 'LIKE', '%'.$keyword.'%')
        ->orWhereHas('member',function ($query) use ($keyword) {
            $query->whereHas('mm', function ($query) use ($keyword) {
                $query->whereHas('member', function($query) use ($keyword){
                    $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('acronym','LIKE','%'.$keyword.'%');
                })->orWhereHas('municipality', function($query) use ($keyword){
                    $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            });
        })->paginate(10);

        return UserResource::collection($users);
    }

    public function store(StoreImage $strmg, StaffRequest $request){
        \DB::transaction(function () use ($request,$strmg){
            if($request->editable){
                $data = User::where('id',$request->id)->update($request->except('img','editable','member_id','municipality_id'));
                $strmg->strmg($request,$request->id);
            }else{
                $data = User::create(array_merge($request->all(), ['password' => bcrypt('dost9ict'), 'type' => 'Member']));
                $strmg->strmg($request,$data->id);

                $mm = MemberMunicipality::where('member_id',$request->member_id)->where('municipality_id',$request->municipality_id)->get();
                if(count($mm) == 0){
                    $mm = MemberMunicipality::create($request->all()); 
                    $mm->user()->create(['user_id' => $data->id]);
                }
            }
        });
    }
}
