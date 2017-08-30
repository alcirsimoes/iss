<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'sample_id'];

    public function samples()
    {
        return $this->belongsToMany('App\Sample');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
