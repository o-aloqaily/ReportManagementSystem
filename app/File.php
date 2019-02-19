<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //

    public function reports()
    {
        return $this->belongsToOne('App\Report');
    }
}
