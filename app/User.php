<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->hasOne('App\UserAdmin');
    }

    public function isSupervisor()
    {
        return $this->hasOne('App\UserSupervisor');
    }

    public function isInterviewer()
    {
        return $this->hasOne('App\UserInterviewer');
    }

    public function isBlack()
    {
        return $this->hasOne('App\Blacklist');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
