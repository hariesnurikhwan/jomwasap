<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $guarded = [];

    public function urls()
    {
        return $this->belongsTo(ShortenedUrl::class);
    }
}
