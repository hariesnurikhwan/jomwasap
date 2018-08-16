<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class RestoreUrlController extends Controller
{

    public function restore($hashid)
    {

        $id = Hashids::decode($hashid)[0];

        $url = ShortenedUrl::onlyTrashed($id)->first();

        if ($url->user_id !== Auth::id()) {
            return abort(404);
        }
        $url->restore();
        return redirect()->route('generate.index');
    }
}
