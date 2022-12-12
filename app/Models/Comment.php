<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    // nom de la fonction au singulier car 1 seul message en relation
    // cardinalité 1,1
    public function quack()
    {
        return $this->belongsTo(Quack::class);
    }

    // idem
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
