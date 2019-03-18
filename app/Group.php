<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

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

    public function reportsCount()
    {
        return $this->reports->count();
    }


}
