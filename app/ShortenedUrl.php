<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use libphonenumber\PhoneNumberFormat;
use Vinkla\Hashids\Facades\Hashids;

class ShortenedUrl extends Model
{
    protected $guarded = [];

    use SoftDeletes;

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

    public function setMobileNumberAttribute($value)
    {
        $this->attributes['mobile_number'] = Str::replaceFirst('+', '', phone($value, 'MY', PhoneNumberFormat::E164));
    }

    public function group()
    {
        return $this->hasMany(Group::class, 'shortened_urls_id');
    }

    public function lead()
    {
        return $this->hasMany(Lead::class);
    }

    public function scopeWhereHashId($query, $hashId)
    {
        return $query->whereKey(Hashids::decode($hashId)[0] ?? 0);
    }
}
