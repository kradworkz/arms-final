<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['station', 'coordinates','code', 'data_logger','remarks','type_id','status_id','municipality_id'];


    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Dropdown', 'type_id', 'id');
    }

    public function getStationAttribute($value)
    {
        return ucwords($value);
    }
    
    public function getDataLoggerAttribute($value)
    {
        return ucwords($value);
    }

    public static function counts($type)
    {   
        if($type == 1){
            $count = Device::where('status_id',19)->count();
        }else{
            $count = Device::where('status_id','!=',19)->count();
        }
        return $count;
    }

}
