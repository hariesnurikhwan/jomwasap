<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function addURL(ShortenedUrl $url)
    {
        return $this->url()->save($url);
    }

    public function url()
    {
        return $this->hasMany(ShortenedUrl::class);
    }

    public function urlCount()
    {
        return $this->url()->count();
    }

    public function totalHitsCount()
    {
        return $this->url()->hitsCount();
    }
}
