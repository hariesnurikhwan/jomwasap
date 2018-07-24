<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadCapture extends Model
{

    protected $guarded = [];

    public function url()
    {
        return $this->belongsTo(ShortenedUrl::class, 'shorterned_urls_id');
    }
}
