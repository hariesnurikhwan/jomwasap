<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ShortenedUrl extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        static::creating(function ($url) {
            $url->alias = self::generateDefaultAliasIfEmpty($url);
        });

        static::updating(function ($url) {
            $url->alias = self::generateDefaultAliasIfEmpty($url);
        });
    }

    private static function generateDefaultAliasIfEmpty(ShortenedUrl $url)
    {
        if ($url->alias === null || $url->alias === '') {
            return str_random(15) . strtotime('now');
        }

        return $url->alias;
    }

    public function getHashidAttribute($value)
    {
        return Hashids::encode($this->id);
    }
}
