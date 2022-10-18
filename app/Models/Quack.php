<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quack extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('app\Models\User', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
