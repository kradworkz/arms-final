<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;
use App\Http\Requests\DropdownRequest;

class DropdownController extends Controller
{   

    public function page(){
        return view('user_admin.lists');
    }

    public function index($classification,$type,$keyword)
    {
        ($keyword == '-') ? $keyword = '' : $keyword;
        ($type == '-') ? $type = '' : $type;
        $data = Dropdown::where('name','LIKE','%'.$keyword.'%')->where('type','LIKE','%'.$type.'%')->where('classification',$classification)->orderBy('id','DESC')->paginate(5);
        return DefaultResource::collection($data);
    }

    public function lists($classification,$type)
    {
        $query = Dropdown::query();
        ($type != '-') ? $query->where('type',$type) : '';
        $data = $query->where('classification',$classification)->get();

        return DefaultResource::collection($data);
    }

    public function store(DropdownRequest $request)
    {
        $data = new Dropdown;
        $data->name =  ucwords(strtolower($request->input('name')));
        $data->type = ($request->input('type')) ? $request->input('type') : 'n/a';
        $data->classification = $request->input('selected');
        $data->color = $request->input('color');
        $data->save();

        return new DefaultResource($data);
    }

    public function count($classification,$type)
    {
        ($type == '-') ? $type = '' : $type;
        $query = Dropdown::query();
        ($type != '') ? $query->where('type',$type) : '';
        $data = $query->where('classification',$classification)->get();

        return DropdownResource::collection($data);
    }
    
}
