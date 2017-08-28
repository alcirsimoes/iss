<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = ['name'];

    public function entries()
    {
        return $this->hasMany('App\Entrie');
    }
}
