<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Searchable;

    public function quack()
    {
        return $this->belongsTo('App\Quack');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
