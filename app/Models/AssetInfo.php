<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetInfo extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo('App\Models\AssetList', 'asset_id', 'id');
    }

    public function getMaintenanceAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function getExpiryAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }
}
