<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','firstname','lastname','birthdate','email', 'password',
        'phonenumber','imageprofile','role','status','update_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function article()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function commentarticle()
    {
        return $this->hasMany('App\Models\CommentArticle');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Categories');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tags');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function galleries()
    {
        return $this->hasMany('App\Models\Gallery');
    }

    public function tutorials()
    {
        return $this->hasMany('App\Models\Tutorial');
    }
}
