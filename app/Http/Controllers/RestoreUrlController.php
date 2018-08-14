<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Http\Request;

class RestoreUrlController extends Controller
{
    public function restore(Request $request)
    {
        $url = ShortenedUrl::onlyTrashed()->where('alias', $request->alias)->first();
        $url->restore();
        return redirect()->route('generate.index');

    }
}
