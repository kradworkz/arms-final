<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;

class DeviceController extends Controller
{
    public function login(Request $request){
        $email = $request->input('username');
        $password = $request->input('password');
        
        try{
                        
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://chirpstack.dost9.ph/api/internal/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "email": "'.$email.'",
            "password": "'.$password.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function check(Request $request){
        $token = $request->input('toks');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://chirpstack.dost9.ph/api/applications?limit=10');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Grpc-Metadata-Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        return $result;
    }

    public function devices(Request $request){
        $token = $request->input('toks');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://chirpstack.dost9.ph/api/devices?limit=10&applicationID=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Grpc-Metadata-Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
       
        $res = json_decode($result);
        if(isset($res->code)){
            if($res->code == 16){
                return $result;
            }
        }else{
            return ApiResource::collection($res->result);
        }
    }
    
    public function search(Request $request){
        $token = $request->input('toks');
        $keyword = $request->input('keyword');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://chirpstack.dost9.ph/api/devices?limit=5&applicationID=1&search='.$keyword);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Grpc-Metadata-Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        
        $res = json_decode($result);
        if(isset($res->code)){
            if($res->code == 16){
                return $result;
            }
        }else{
            return ApiResource::collection($res->result);
        }
    }
}
