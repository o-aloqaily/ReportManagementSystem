<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role');
    }


    // Helper Functions

    // Returns true if the user has the role "admin"
    public function isAdmin()
    {
        return $this->roles->contains('Admin');
    }


    // Returns the number of groups that the users is enrolled in
    public function groupsCount()
    {
        return $this->groups->count();
    }

    // Returns a string containing the user's roles, separated by a comma ','
    public function getCurrentRoles()
    {
        $roles = '';
        foreach($this->roles as $role) {
            if ($roles == '') {
                $roles = $role->role;
            } else {
                $roles = $roles.', '.$role->role;
            }
        }
        return $roles;
    }
    





}
