<?php

namespace App\Services;


class StoreImage2 {

    public static function strmg($data,$name) {

        
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
        \File::put(public_path('images/avatars'). '/' . $imageName, base64_decode($image));
        
        return $imageName;

    }
    
}