<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $primaryKey = 'title';
    public $incrementing = false;

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function membersCount()
    {
        return $this->users->count();
    }


}
