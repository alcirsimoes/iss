<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['name', 'init_at', 'end_at', 'active'];

    public function samples()
    {
        return $this->hasMany('App\Sample');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
