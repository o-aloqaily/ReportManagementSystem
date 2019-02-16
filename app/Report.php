<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function user()
    {
        return $this->belongsToOne('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }


}
