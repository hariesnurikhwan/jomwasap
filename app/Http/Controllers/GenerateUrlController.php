<?php

namespace App\Http\Controllers;

use App\Group;
use App\ShortenedUrl;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'type'                => [
                'required',
                Rule::in(['single', 'group']),
                'bail',
            ],
            'alias'               => [
                'sometimes',
                Rule::unique('shortened_urls'),
            ],
            'mobile_number'       => [
                'required_if:type,single',
                'nullable',
                'phone:MY',
            ],
            'mobile_numbers'      => [
                'required_if:type,group',
                'nullable',
                'between:2,5',
            ],
            'mobile_numbers.*'    => 'distinct|phone:MY',
            'enable_lead_capture' => [
                'boolean',
                'required',
            ],
        ]);

        if ($request->file('image')) {

            $pathName = $request->alias . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/og'), $pathName);

        }

        if ($request->type === 'single') {

            $url = Auth::user()->addUrl(new ShortenedUrl([
                'alias'               => $request->alias,
                'mobile_number'       => $request->mobile_number,
                'text'                => $request->text,
                'type'                => $request->type,
                'enable_lead_capture' => $request->enable_lead_capture,
                'title'               => $request->title,
                'description'         => $request->description,
                'image'               => $pathName,
            ]));

            dd($url);

        } elseif ($request->type === 'group') {

            $url = Auth::user()->addURL(new ShortenedUrl(
                $request->only(['alias', 'type', 'text', 'enable_lead_capture', 'title', 'description'])
            ));

            foreach ($request->mobile_numbers as $number) {
                $url->group()->create([
                    'mobile_number' => $number,
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
            'type'                 => [
                'required',
                Rule::in(['single', 'group']),
                'bail',
            ],
            'alias'                => [
                'required',
                Rule::unique('shortened_urls')->ignore($url->id),
            ],
            'text'                 => 'sometimes|max:5000',
            'mobile_number'        => [
                'required_if:type,single',
                'phone:MY',
            ],
            'old_mobile_numbers.*' => [
                'distinct',
                'phone:MY',
            ],
            'mobile_numbers'       => [
                'between:2,5',
            ],
            'mobile_numbers.*'     => [
                'distinct',
                'phone:MY',
            ],
            'enable_lead_capture'  => [
                'boolean',
                'required',
            ],
        ]);

        if ($url->type === 'single') {

            $url->update($request->only('alias', 'mobile_number', 'text', 'enable_lead_capture'));

        } elseif ($url->type === 'group') {

            $existingNumber = $url->group()->pluck('mobile_number')->toArray();

            if ($request->mobile_numbers && $request->old_mobile_numbers) {
                $mobile_numbers = array_merge($request->mobile_numbers, $request->old_mobile_numbers);
            } elseif ($request->old_mobile_numbers) {
                $mobile_numbers = $request->old_mobile_numbers;
            } elseif ($request->mobile_numbers) {
                $mobile_numbers = $request->mobile_numbers;
            }

            $editedNumbers = array_diff($existingNumber, $mobile_numbers);

            $url->update($request->only('alias', 'text', 'enable_lead_capture'));

            foreach ($mobile_numbers as $number) {
                $url->group()->firstOrCreate(['mobile_number' => $number]);
            }

            foreach ($editedNumbers as $number) {
                $url->group()->where('mobile_number', $number)->delete();
            }

        }

        return redirect()->route('generate.show', $url->hashid);
    }
}
