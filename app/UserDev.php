<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDev extends Model
{
    public $fillable = ['user_id'];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
