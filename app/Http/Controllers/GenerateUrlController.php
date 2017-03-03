<?php

namespace App\Http\Controllers;

use App\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenerateUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $urls = $user->url()->paginate(20);

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
            'alias' => [
                'sometimes',
                Rule::unique('shortened_urls'),
            ],
            'mobile_number' => 'required|phone:MY',
            'text' => 'sometimes|max:500',
        ]);

        $user = auth()->user();

        $url = $user->url()->create([
            'alias' => $request->alias,
            'mobile_number' => phone($request->mobile_number, 'MY', PhoneNumberFormat::E164),
            'text' => $request->text,
        ]);

        return redirect()->route('generate.show', $url->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShortenedUrl $url)
    {
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
        return view('generate.show', [
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
            'alias' => [
                'sometimes',
                Rule::unique('shortened_urls')->ignore($url),
            ],
            'mobile_number' => 'required|phone:MY',
            'text' => 'sometimes|max:500',
        ]);

        $url = ShortenedUrl::create([
            'alias' => $request->alias,
            'mobile_number' => phone($request->mobile_number, 'MY', PhoneNumberFormat::E164),
            'text' => $request->text,
        ]);

        return redirect()->route('generate.show', $url->id);
    }
}
