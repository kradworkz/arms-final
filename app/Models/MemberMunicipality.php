<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberMunicipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'municipality_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\UserMember', 'mm_id');
    } 

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'id');
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
