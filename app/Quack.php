<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quack extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function commentaires()
    {
        return $this->hasMany('App\Commentaire')->latest();
    }

    public function commentairesValide()
    {
        return $this->hasMany('App\Commentaire')->where('valide', 1)->latest();
    }
}
