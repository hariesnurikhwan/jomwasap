<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortenedUrlHits extends Model
{
    protected $guarded = [];

    public function lead()
    {
        return $this->belongsTo(ShortenedUrl::class);
    }
}
