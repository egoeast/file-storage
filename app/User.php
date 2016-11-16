<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'max_disk_space', 'disk_space', 'is_admin', 'is_blocked'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userFile(){
        return $this->hasMany('App\UserFile');
    }

    /**
     * @return bool
     */
    public function isBlocked(){
        if ($this->is_blocked) return true;
    }

    /**
     * @return bool
     */
    public function isAdmin(){
        if ($this->is_admin) return true;
    }

    /**
     * @return bool
     */
    public function isActive(){
        if ($this->is_active) return true;
    }
}
