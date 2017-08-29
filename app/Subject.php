<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'sample_id'];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
