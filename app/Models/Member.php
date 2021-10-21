<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\StringFixer;

class Member extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['name', 'acronym', 'avatar','type','status'];

    public function user()
    {
        return $this->hasMany('App\Models\UserMember', 'member_id');
    }

    public function getNameAttribute($value){
        return StringFixer::uppercaseExcept($value);
    }

    public function getAcronymAttribute($value){
        return strtoupper($value);
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
