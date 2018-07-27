<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LeadController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'alias'         => 'required|exists:shortened_urls',
            'name'          => 'required',
            'mobile_number' => 'required|phone:MY',
        ]);

        $url = ShortenedUrl::whereAlias($request->alias)->firstOrFail();

        $cookie = Cookie::forever($url->alias, true);

        $url->lead()->create(['name' => $request->name, 'mobile_number' => $request->mobile_number]);

        return redirect()->action('VisitUrlController@go', ['alias' => $request->alias])->cookie($cookie);
    }

    public function toggle($alias)
    {
        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $url->switchLeadCapture();

        return $url;

    }
}
