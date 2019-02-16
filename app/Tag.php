<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //

    protected $primaryKey = 'title';

    public function reports()
    {
        return $this->belongsToMany('App\Report');
    }

}
