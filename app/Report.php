<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id', 'group_title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'report_tag', 'report_id', 'tag_title');
    }

    public function group()
    {
        return $this->belongsTo('App\Group', 'group_title');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function images() {
        $images = $this->files->filter(function($file, $key) {
            $allowedExtensions = config('files.allowedImagesExtensions');
            $fileExtension = pathinfo($file->path, PATHINFO_EXTENSION);
            return in_array($fileExtension, $allowedExtensions);
        });
        return $images->all();
    }

    public function audios() {
        $audios = $this->files->filter(function($file, $key) {
            $allowedExtensions = config('files.allowedAudioFilesExtensions');
            $fileExtension = pathinfo($file->path, PATHINFO_EXTENSION);
            return in_array($fileExtension, $allowedExtensions);
        });
        return $audios->all();
    }


    public function hasTags($arrayOfTags) {
        $diffArray = $this->tags->diff($arrayOfTags);
        if (sizeof($diffArray) >= 0 && sizeof($diffArray) < sizeof($this->tags))
            return true;
        else {
            return false;
        }
    }
}
