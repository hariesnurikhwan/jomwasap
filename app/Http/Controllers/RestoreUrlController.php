<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Support\Facades\Auth;

class RestoreUrlController extends Controller
{

    public function restore($hashId)
    {
        $url = ShortenedUrl::onlyTrashed()
            ->whereHashId($hashId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $url->restore();

        return redirect()->route('generate.index');
    }
}
