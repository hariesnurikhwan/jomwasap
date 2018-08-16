<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Support\Facades\Auth;

class RestoreUrlController extends Controller
{

    public function restore($hashId)
    {
        $url = ShortenedUrl::onlyTrashed()->whereHashId($hashId)->firstOrFail();

        if ($url->user_id !== Auth::id()) {
            return abort(404);
        }
        $url->restore();
        return redirect()->route('generate.index');
    }
}
