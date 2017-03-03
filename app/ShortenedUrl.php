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
            if ($url->alias === null || $url->alias === '') {
                $url->alias = self::generateDefaultAlias();
            }
        });

        static::updating(function ($url) {
            if ($url->alias === null || $url->alias === '') {
                $url->alias = self::generateDefaultAlias();
            }
        });
    }

    private static function generateDefaultAlias()
    {
        return str_random(15) . strtotime('now');
    }

    public function getHashidAttribute($value)
    {
        return Hashids::encode($this->id);
    }
}
