<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //

    protected $primaryKey = 'title';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];


    public function reports()
    {
        return $this->belongsToMany('App\Report', 'report_tag', 'tag_title', 'report_id');
    }

}
