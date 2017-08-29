<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
