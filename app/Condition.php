<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    public $fillable = ['show', 'question_id', 'option_id', 'to_question_id', 'to_option_id'];
}
