<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;

class StoreImage {

    public static function strmg($request,$id) {

        if($request->input('img') != ''){
            ($request->input('acronym') != '') ? $name = strtolower($request->input('acronym')).'-'.$id : $name = $id;
            $data = $request->input('img');
            $img = explode(',', $data);
            $ini =substr($img[0], 11);
            $type = explode(';', $ini);
            if($type[0] == 'png'){
                $image = str_replace('data:image/png;base64,', '', $data);
            }else{
                $image = str_replace('data:image/jpeg;base64,', '', $data);
            }
            $image = str_replace(' ', '+', $image);
            $imageName = $name.'.'.$type[0];
            
            if(\File::put(public_path('images/avatars'). '/' . $imageName, base64_decode($image))){
                ($request->input('acronym')!= '') ? $data = Member::findOrFail($id) : $data = User::findOrFail($id);
                $data->avatar = $imageName;
                $data->save();
            }
        }
        return true;
    }
    
}