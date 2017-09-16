<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['name', 'init_at', 'end_at', 'intro', 'active'];

    public function samples()
    {
        return $this->belongsToMany('App\Sample')->withPivot('active');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function conditions()
    {
        return $this->hasManyThrough('App\Condition', 'App\Question');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
