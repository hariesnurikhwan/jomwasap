<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ShortenedUrl extends Model
{
    protected $guarded = [];

    public function setAliasAttribute($value)
    {
        if ($value === null || $value === '') {
            $this->attributes['alias'] = str_random(5) . strtotime('now');
        } else {
            $this->attributes['alias'] = $value;
        }
    }

    public function getHashidAttribute($value)
    {
        return Hashids::encode($this->id);
    }

    public function group()
    {
        return $this->hasMany(Group::class);
    }

    public function lead()
    {
        return $this->hasMany(Lead::class);
    }

    public function hits()
    {
        return $this->hasMany(ShortenedUrlHits::class);
    }

    public function newHit(ShortenedUrlHits $hit)
    {
        return $this->hits()->save($hit);
    }

}
