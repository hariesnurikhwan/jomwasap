<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use libphonenumber\PhoneNumberFormat;

class Group extends Model
{

    protected $guarded = [];

    public function setMobileNumberAttribute($value)
    {
        $this->attributes['mobile_number'] = Str::replaceFirst('+', '', phone($value, 'MY', PhoneNumberFormat::E164));
    }

    public function urls()
    {
        return $this->belongsTo(ShortenedUrl::class, 'shortened_urls_id');
    }
}
