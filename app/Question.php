<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['survey_id', 'name', 'statement', 'type', 'format', 'answers_header', 'options_header', 'order', 'other','none','unknow'];

    public function answer()
    {
        return $this->hasOne('App\Answer');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question', 'question_question', 'father_id', 'question_id');
    }

    public function father()
    {
        return $this->belongsToMany('App\Question', 'question_question', 'question_id', 'father_id');
    }

    public function options()
    {
        return $this->belongsToMany('App\Option');
    }

    public function jumps()
    {
        return $this->belongsToMany('App\Jump');
    }
}
