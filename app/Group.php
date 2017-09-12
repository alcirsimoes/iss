<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $fillable = ['name'];

    public function options()
    {
        return $this->hasMany('App\Option');
    }
}
