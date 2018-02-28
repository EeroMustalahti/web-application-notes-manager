<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email', 'password',
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
     * Give or remove moderator role and return message.
     *
     * @return string
     */
    public function toggleModerator()
    {
        $modeRole = Role::where('name', 'moderator')->first();
        if($this->roles()->find($modeRole->id)) {
            $this->roles()->detach($modeRole->id);
            return 'User "' . $this->name . '" is no longer moderator';
        } else {
            $this->roles()->attach($modeRole->id);
            return 'User "' . $this->name . '" is now moderator';
        }
    }

    public function notes()
    {
        return $this->hasMany(Note::class)->latest();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
