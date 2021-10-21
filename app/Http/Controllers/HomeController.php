<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->type == "Administrator"){
            return view('user_admin.index');    
        }else if(Auth::user()->type == "Member"){
            return view('user_member.index');
        }else{
            return view('user_top.index');
        }
    }

    public function password(Request $request){

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json(['error' => "Password doesn't match."], 401);
        }

        if(strcmp($request->get('current_password'), $request->get('password')) == 0){
            return response()->json(['error' => 'Please choose a different password'], 401);
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:9|confirmed',
        ]);

        User::find(\Auth::user()->id)->update(['password'=> Hash::make($request->input('password'))]);

        if(Auth::user()->status == 'Inactive'){
            User::find(auth()->user()->id)->update(['status'=> 'Active']);
            return response()->json(['success' => 'First Attempt'], 200);
        }else{
            return response()->json(['success' => 'Password changed successfully !'], 200);
        }

    }

    public function regions()
    {
        $data = LocationRegion::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function provinces($id)
    {
        $data = LocationProvince::where('region_id',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function municipalities($id)
    {
        $data = LocationMunicipality::where('province_id',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function agency(){
        // $data = \Auth::user()->member->mm->member;

        $data[] = [  
            'agency' => \Auth::user()->member->mm->member,
            'address' => \Auth::user()->member->mm->municipality,
        ];
        return $data;
    }

    

    
}
