<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationMunicipality extends Model
{
    use HasFactory;

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_id', 'id');
    }
}
