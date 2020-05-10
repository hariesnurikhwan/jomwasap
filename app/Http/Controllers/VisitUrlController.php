<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Jenssegers\Agent\Agent;

class VisitUrlController extends Controller
{
    public function go($alias)
    {

        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $text = rawurlencode($url->text);

        if ($url->type === 'single') {
            // $mobileNumber = phone($url->mobile_number, 'MY', PhoneNumberFormat::E164);
            $mobileNumber = $url->mobile_number;
        } elseif ($url->type === 'group') {
            $mobileNumbers = $url->group()->get(['mobile_number', 'id']);
            if ($mobileNumbers->count() >= 2) {
                $mobileNumber = $mobileNumbers->first(function ($mobileNumber) use ($url, $mobileNumbers) {
                    return $mobileNumber->id > $url->group_id || $url->group_id == $mobileNumbers->keyBy('id')->last()->id;
                }, $mobileNumbers->first());

                $url->update([
                    'group_id' => $mobileNumber->id,
                ]);
            } else {
                $mobileNumber = $mobileNumbers->first();
            }
            $mobileNumber = $mobileNumber->mobile_number;
        }

        $redirectApp = "whatsapp://send?text={$text}&phone={$mobileNumber}";
        $redirectWeb = "https://web.whatsapp.com/send?text={$text}&phone={$mobileNumber}";

        $agent = new Agent();

        if ($agent->isMobile()) {
            return redirect($redirectApp);
        }

        return view('redirector', [
            'url'         => $url,
            'redirectApp' => $redirectApp,
            'redirectWeb' => $redirectWeb,
            'os'          => $agent->platform(),
        ]);
    }

}
