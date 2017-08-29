<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function subject()
    {
        return $this->hasOne('App\Subject');
    }

    public function questions()
    {
        return $this->hasOne('App\Question');
    }

    public function options()
    {
        return $this->belongsToMany('App\Options');
    }
}
