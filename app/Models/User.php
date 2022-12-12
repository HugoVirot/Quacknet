<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pseudo', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // nom au pluriel car un user peut poster plusieurs quacks
    // cardinalité 0,n
    public function quacks()
    {
        return $this->hasMany(Quack::class);
    }

    // nom au pluriel car un user peut poster plusieurs commentaires
    // cardinalité 0,n
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // nom de la fonction au singulier car 1 seul rôle en relation
    // cardinalité 1,1
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role == "admin";
    }
}
