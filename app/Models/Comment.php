<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public function quack()
    {
        return $this->belongsTo('app\Models\Quack');
    }

    public function user()
    {
        return $this->belongsTo('app\Models\User');
    }
}
