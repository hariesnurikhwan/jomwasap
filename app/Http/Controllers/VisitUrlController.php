<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Jenssegers\Agent\Agent;
use libphonenumber\PhoneNumberFormat;

class VisitUrlController extends Controller
{
    public function go($alias)
    {
        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $text = rawurlencode($url->text);

        if ($url->type === 'single') {
            $mobileNumber = phone($url->mobile_number, 'MY', PhoneNumberFormat::E164);
        } elseif ($url->type === 'group') {
            $numbers      = $url->group->pluck('mobile_number')->toArray();
            $mobileNumber = phone($numbers[array_rand($numbers)], 'MY', PhoneNumberFormat::E164);
        }

        $redirectApp = "whatsapp://send?text={$text}&phone={$mobileNumber}";
        $redirectWeb = "https://web.whatsapp.com/send?text={$text}&phone={$mobileNumber}";

        $agent = new Agent();

        if ($agent->isMobile()) {
            return redirect($redirectApp);
        }

        return view('redirector', [
            'redirectApp' => $redirectApp,
            'redirectWeb' => $redirectWeb,
            'os'          => $agent->platform(),
        ]);
    }
}
