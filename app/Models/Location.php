<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function assets()
    {
        return $this->hasMany('App\Models\AssetLocation', 'location_id')->sum('quantity');
    }

    public function mm()
    {
        return $this->belongsTo('App\Models\MemberMunicipality', 'mm_id', 'id');
    }
}
