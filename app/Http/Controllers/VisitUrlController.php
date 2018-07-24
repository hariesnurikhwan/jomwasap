<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;
use libphonenumber\PhoneNumberFormat;

class VisitUrlController extends Controller
{
    public function go($alias)
    {

        if (!Cookie::get($alias)) {
            return view('lead', [
                'alias' => $alias,
            ]);
        }

        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        $text = rawurlencode($url->text);

        if ($url->type === 'single') {
            $mobileNumber = phone($url->mobile_number, 'MY', PhoneNumberFormat::E164);
        } elseif ($url->type === 'group') {
            $mobileNumber = $url->group()->inRandomOrder()->first();
            $mobileNumber = phone($mobileNumber->mobile_number, 'MY', PhoneNumberFormat::E164);
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

    public function lead(Request $request)
    {

        $this->validate($request, [
            'alias'         => 'required',
            'name'          => 'required',
            'mobile_number' => 'required|phone:MY',
        ]);

        $url = ShortenedUrl::whereAlias($request->alias)->firstOrFail();

        $cookie = Cookie::forever($url->alias, true);

        $url->lead()->create(['name' => $request->name, 'mobile_number' => $request->mobile_number]);

        return redirect()->action('VisitUrlController@go', ['alias' => $request->alias])->cookie($cookie);
    }

}
