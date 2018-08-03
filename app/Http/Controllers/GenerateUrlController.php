<?php

namespace App\Http\Controllers;

use App\Group;
use App\ShortenedUrl;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'max:255',
            ],
            'alias'               => [
                'nullable',
                Rule::unique('shortened_urls'),
                'regex:/^[a-zA-Z0-9_-]*$/',
            ],
            'text'                => 'nullable|max:5000',
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
            'title'               => 'required_with:description|max:255',
            'description'         => 'required_with:title|max:255',
            'image'               => 'required_with:title,description|image',
        ]);

        $url = DB::transaction(function () use ($request) {
            if ($request->hasFile('image')) {
                $pathName = $request->image->store('meta');
            }

            $newUrl = [
                'alias'               => $request->alias,
                'text'                => $request->text,
                'type'                => $request->type,
                'enable_lead_capture' => $request->enable_lead_capture,
            ];

            if ($request->has('title')) {
                $newUrl = array_merge($newUrl, [
                    'title'       => $request->title,
                    'description' => $request->description,
                    'image'       => $pathName,
                ]);
            }

            if ($request->has('mobile_number')) {
                $newUrl = array_merge($newUrl, ['mobile_number' => $request->mobile_number]);
            }

            $url = Auth::user()->addUrl(new ShortenedUrl($newUrl));

            if ($request->type === 'group') {
                foreach ($request->mobile_numbers as $number) {
                    $url->group()->create([
                        'mobile_number' => $number,
                    ]);
                }
            }

            return $url;
        });

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
            'type'                => [
                'required',
                Rule::in(['single', 'group']),
                'bail',
            ],
            'alias'               => [
                'nullable',
                Rule::unique('shortened_urls')->ignore($url->id),
                'regex:/^[a-zA-Z0-9_-]*$/',
                'max:255',
            ],
            'text'                => 'nullable|max:5000',
            'mobile_number'       => [
                'required_if:type,single',
                'phone:MY',
            ],
            'mobile_numbers'      => [
                'required_if:type,group',
                'between:2,5',
            ],
            'mobile_numbers.*'    => [
                'distinct',
                'phone:MY',
            ],
            'enable_lead_capture' => [
                'boolean',
                'required',
            ],
            'title'               => 'required_with:description|max:255',
            'description'         => 'required_with:title|max:255',
            'image'               => 'nullable|image',
        ]);

        $url = DB::transaction(function () use ($request, $url) {

            if ($request->hasFile('image')) {
                $pathName = $request->image->store('meta', 'public');
            }

            $editUrl = [
                'alias'               => $request->alias,
                'text'                => $request->text,
                'type'                => $request->type,
                'enable_lead_capture' => $request->enable_lead_capture,
            ];

            if ($request->has('title')) {
                $editUrl = array_merge($editUrl, [
                    'title'       => $request->title,
                    'description' => $request->description,
                    'image'       => $pathName ?? $url->image,
                ]);
            }

            if ($request->has('mobile_number')) {
                $editUrl = array_merge($editUrl, ['mobile_number' => $request->mobile_number]);
            }

            $url->update($editUrl);

            if ($url->type === 'group') {

                $existingNumber = $url->group()->pluck('mobile_number')->toArray();

                $mobile_numbers = $request->mobile_numbers;

                $editedNumbers = array_diff($existingNumber, $mobile_numbers);

                foreach ($mobile_numbers as $number) {
                    $url->group()->firstOrCreate(['mobile_number' => $number]);
                }

                foreach ($editedNumbers as $number) {
                    $url->group()->where('mobile_number', $number)->delete();
                }
            }

            return $url;

        });

        return redirect()->route('generate.show', $url->hashid);
    }
}
