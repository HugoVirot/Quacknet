<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quack extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }
//
//    public function commentsValidated()
//    {
//        return $this->hasMany('App\Comment')->where('valide', 1)->latest();
//    }
}
