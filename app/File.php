<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'report_id', 'path'
    ];


    public function report()
    {
        return $this->belongsToOne('App\Report');
    }
}
