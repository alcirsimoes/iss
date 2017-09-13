<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['user_id','name','company','address','state','city','ocupation','telephone'];

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
