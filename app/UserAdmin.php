<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
