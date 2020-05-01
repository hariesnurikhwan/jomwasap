<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use libphonenumber\PhoneNumberFormat;

class Group extends Model
{

    protected $guarded = [];

    public function setMobileNumberAttribute($value)
    {
        $this->attributes['mobile_number'] = phone($value, 'MY', PhoneNumberFormat::E164);
    }

    public function urls()
    {
        return $this->belongsTo(ShortenedUrl::class, 'shortened_urls_id');
    }
}
