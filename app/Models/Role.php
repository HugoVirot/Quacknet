<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // nom au pluriel car un rôle peut regrouper plusieurs users
    // cardinalité 1,n
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
