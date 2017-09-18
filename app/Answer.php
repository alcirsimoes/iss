<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $fillable = ['user_id', 'sample_id', 'subject_id', 'question_id', 'value'];

    public function survey()
    {
        return $this->hasOne('App\Survey');
    }

    public function sample()
    {
        return $this->hasOne('App\Sample');
    }

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
        return $this->belongsToMany('App\Option')->withPivot('sub_option_id', 'value');
    }
}
