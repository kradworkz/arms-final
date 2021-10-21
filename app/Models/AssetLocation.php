<?php

namespace App\Models;

use App\Models\Dropdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLocation extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo('App\Models\Asset', 'asset_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\AssetList', 'assetlocation_id');
    }

    public function available()
    {
        $status = Dropdown::select('id')->where('classification','Status')->where('name','Operational')->first();
        return $this->hasMany('App\Models\AssetList', 'assetlocation_id')->where('status_id',$status->id)->count();
    }

    public function tracker()
    {
        return $this->hasMany('App\Models\AssetList', 'assetlocation_id')->where('tracker_code','!=',NULL)->count();
    }
    
    
    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
