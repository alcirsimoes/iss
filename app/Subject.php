<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id','name','email','company','address','state','city','ocupation','telephone'];

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
