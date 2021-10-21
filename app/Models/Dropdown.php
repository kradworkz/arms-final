<?php

namespace App\Models;

use App\Models\AsseList;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function assets()
    {
        return $this->hasMany('App\Models\AssetList', 'status_id');
    }

    public function assetcategory()
    {
        return $this->hasMany('App\Models\Asset', 'category_id');
    }

    public function getColorAttribute($value)
    {
        if($value == 'violet' ){
            return 'primary';
        }else if($value == 'blue'){
            return 'info';
        }else if($value == 'red'){
            return 'danger';
        }else if($value == 'yellow'){
            return 'warning';
        }else if($value == 'black'){
            return 'dark';
        }else if($value == 'gray'){
            return 'secondary';
        }else{
            return 'success';
        }
    }

    public function lists(){
        $member_id = \Auth::user()->member->mm->id;
        return $this->hasMany('App\Models\AssetList', 'status_id') 
        ->whereHas('assetlocation', function ($query) use ($member_id){
            $query->whereHas('asset', function ($query) use ($member_id){
                $query->where('mm_id',$member_id);
            });
        })->count();
    }

    public function count()
    {   
        if($this->classification == "Category"){
            $count = AssetList::whereHas('assetlocation', function ($query){
                $query->whereHas('asset', function ($query){
                    $query->where('category_id',$this->id);
                });
            })
            ->where('coordinates','!=', '')
            ->count();
        }else if($this->classification == "Device"){
            $count = Device::where('type_id',$this->id)
            ->count();
        }else{
            $count = Device::where('status_id',$this->id)
            ->count();
        }

        return $count;

        // $count = AssetLocation::whereHas('asset', function ($query){
        //     $query->where('category_id',$this->id);
        // })
        // ->whereHas('lists', function ($query){
        //     $query->where('coordinates','!=',NULL);
        // })
        // ->count();

        // return $count;
    }

    public function aw()
    {
        $count = $this->hasMany('App\Models\AssetList', 'status_id')->count();

        $available = $this->hasMany('App\Models\AssetList', 'status_id')->where('is_available',1)->count();
        $notavailable = $this->hasMany('App\Models\AssetList', 'status_id')->where('is_available',0)->count();

        if($count != 0){
            $a = $available / $count * 100;
            $na = $notavailable / $count * 100;
        }else{
            $a = 0;
            $na = 0;
        }

        $data = [
            $counts[] = [
                'name' => 'Available',
                'count' => $available,
                'percentage' => floor($a),
                'color' => 'success'
            ], 
            $counts[] = [
                'name' => 'Not Available',
                'count' => $notavailable,
                'percentage' => floor($na),
                'color' => 'danger'
            ]
        ];

        return $data;

    }


    
}
