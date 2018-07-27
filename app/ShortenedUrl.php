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
        return $this->hasMany(Group::class, 'shortened_urls_id');
    }

    public function lead()
    {
        return $this->hasMany(Lead::class);
    }

    public function switchLeadCapture()
    {
        $this->enable_lead_capture = !$this->enable_lead_capture;
        $this->save();
    }
}
