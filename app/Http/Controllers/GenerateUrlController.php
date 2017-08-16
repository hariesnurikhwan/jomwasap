<?php

namespace App\Http\Controllers;

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
            'alias'         => [
                'sometimes',
                Rule::unique('shortened_urls'),
            ],
            'mobile_number' => 'required|phone:MY',
            'text'          => 'sometimes|max:5000',
        ]);

        $url = Auth::user()->addURL(new ShortenedUrl(
            $request->only(['alias', 'mobile_number', 'text'])
        ));

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
            'alias'         => [
                'required',
                Rule::unique('shortened_urls')->ignore($url->id),
            ],
            'mobile_number' => 'required|phone:MY',
            'text'          => 'sometimes|max:5000',
        ]);

        $url->update($request->only('alias', 'mobile_number', 'text'));

        return redirect()->route('generate.show', $url->hashid);
    }
}
