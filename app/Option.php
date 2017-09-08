<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $fillable = ['statement', 'value'];

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    public function jumps()
    {
        return $this->belongsToMany('App\Jump');
    }
}
