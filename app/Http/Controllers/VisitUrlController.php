<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;

class VisitUrlController extends Controller
{
    public function go($alias)
    {
        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $text = rawurlencode($url->text);

        $redirectWhatsApp = 'whatsapp://send?text=' . $text . '&phone=' . $url->mobile_number;

        return redirect($redirectWhatsApp);
    }
}
