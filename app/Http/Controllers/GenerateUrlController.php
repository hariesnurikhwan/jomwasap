<?php

namespace App\Http\Controllers;

use App\Group;
use App\ShortenedUrl;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenerateUrlController extends Controller
{
    public function __construct()
    {
        $this->middleware('URLMustBelongToOwner')->only([
            'show',
            'edit',
            'update',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = ShortenedUrl::where('user_id', Auth::id())
            ->paginate(20);

        return view('generate.index', [
            'urls' => $urls,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('generate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'type' => [
                'required',
                Rule::in(['single', 'group']),
                'bail',
            ],
        ]);

        if ($request->type === 'single') {
            $this->validate($request, [
                'alias'         => [
                    'sometimes',
                    Rule::unique('shortened_urls'),
                ],
                'mobile_number' => 'required|phone:MY',
                'text'          => 'sometimes|max:5000',
            ]);

            $url = Auth::user()->addURL(new ShortenedUrl(
                $request->only(['alias', 'mobile_number', 'text', 'type'])
            ));
        } elseif ($request->type === 'group') {

            $this->validate($request, [
                'alias'            => [
                    'sometimes',
                    Rule::unique('shortened_urls'),
                ],
                'mobile_numbers'   => 'required|array|between:2,5',
                'mobile_numbers.*' => 'distinct|phone:MY',
            ]);

            $url = Auth::user()->addURL(new ShortenedUrl(
                $request->only(['alias', 'type', 'text'])
            ));

            foreach ($request->mobile_numbers as $number) {
                Group::create([
                    'shortened_urls_id' => $url->id,
                    'mobile_number'     => $number,
                ]);
            }

        }

        return redirect()->route('generate.show', $url->hashid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShortenedUrl $url)
    {

        // dd($url->group->pluck('mobile_number')[0]);
        return view('generate.show', [
            'url' => $url,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShortenedUrl $url)
    {
        return view('generate.edit', [
            'url' => $url,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShortenedUrl $url)
    {

        $this->validate($request, [
            'type' => [
                'required',
                Rule::in(['single', 'group']),
                'bail',
            ],
        ]);

        if ($url->type === 'single') {
            $this->validate($request, [
                'alias'         => [
                    'required',
                    Rule::unique('shortened_urls')->ignore($url->id),
                ],
                'mobile_number' => 'required|phone:MY',
                'text'          => 'sometimes|max:5000',
            ]);

            $url->update($request->only('alias', 'mobile_number', 'text'));

        } elseif ($url->type === 'group') {
            $this->validate($request, [
                'mobile_numbers'   => 'required|array|between:2,5',
                'mobile_numbers.*' => 'distinct|phone:MY',
            ]);

            $url->update($request->only('alias', 'text'));

            if (is_array($request->mobile_numbers) || is_object($request->mobile_numbers)) {
                foreach ($request->mobile_numbers as $number) {
                    if (!Group::where('mobile_number', $number)->exists()) {
                        Group::create([
                            'shortened_urls' => $url->id,
                            'mobile_number'  => $number,
                        ]);
                    }
                }
            }

            if (is_array($request->new_mobile_numbers) || is_object($request->new_mobile_numbers)) {
                foreach ($request->new_mobile_numbers as $number) {
                    Group::create([
                        'shortened_urls_id' => $url->id,
                        'mobile_number'     => $number,
                    ]);
                }
            }

            $diff = array_diff($url->group->pluck('mobile_number')->toArray(), $request->mobile_numbers);

            if (is_array($diff) || is_object($diff)) {
                foreach ($diff as $number) {
                    Group::where('mobile_number', $number)->delete();
                }
            }

        }

        return redirect()->route('generate.show', $url->hashid);
    }
}
