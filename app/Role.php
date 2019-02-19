<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    protected $primaryKey = 'role';
    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany('App\User');
    }


}
