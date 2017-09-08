<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = ['name'];

    public function surveys()
    {
        return $this->belongsToMany('App\Survey');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject');
    }

    public function entries()
    {
        return $this->hasMany('App\Entrie');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
