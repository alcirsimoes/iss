<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;
    
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
