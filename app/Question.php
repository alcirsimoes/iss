<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['survey_id', 'name', 'statement', 'type', 'order', 'other'];

    public function questions()
    {
        return $this->belongsToMany('App\Question', 'question_questions', 'father_id', 'question_id');
    }

    public function options()
    {
        return $this->belongsToMany('App\Option');
    }
}
