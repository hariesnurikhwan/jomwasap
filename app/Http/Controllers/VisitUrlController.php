<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use libphonenumber\PhoneNumberFormat;

class VisitUrlController extends Controller
{
    public function go($alias)
    {
        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $text = rawurlencode($url->text);

        $mobileNumber = phone($url->mobile_number, 'MY', PhoneNumberFormat::E164);

        $redirectWhatsApp = "whatsapp://send?text={$text}&phone={$mobileNumber}";

        return redirect($redirectWhatsApp);
    }
}
