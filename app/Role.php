<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];


    protected $primaryKey = 'role';
    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany('App\User');
    }


}
