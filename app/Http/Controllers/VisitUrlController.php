<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use libphonenumber\PhoneNumberFormat;

class VisitUrlController extends Controller
{
    /**
     * Get current OS from request. Code by Jasdy Sharman
     */
    private function getOS()
    {
        $os_array = array(
            '/windows nt 10/i'      => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile',
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, request()->header('User-Agent'))) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    public function go($alias)
    {
        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $text = rawurlencode($url->text);

        $mobileNumber = phone($url->mobile_number, 'MY', PhoneNumberFormat::E164);

        if (in_array($this->getOS(), array('Android', 'iPhone', 'Blackberry', 'Mobile'))) {
            return redirect("whatsapp://send?text={$text}&phone={$mobileNumber}");
        }

        return redirect("https://web.whatsapp.com/send?text={$text}&phone={$mobileNumber}");
    }
}
