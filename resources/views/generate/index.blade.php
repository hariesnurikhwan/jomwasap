@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="alert alert-dark" role="alert">
                <div class="row">
                    <div class="col">
                        <h4 class="alert-heading">Bulding JOMWasap to the next level!</h4>
                    </div>
                    <div class="col-auto">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="alert-english-tab" data-toggle="pill" href="#alert-english" role="tab" aria-controls="alert-english" aria-selected="true">English</a>
                                </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="alert-malay-tab" data-toggle="pill" href="#alert-malay" role="tab" aria-controls="alert-malay" aria-selected="false">Melayu</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="alert-english" role="tabpanel" aria-labelledby="pills-home-tab">
                        <p class="mb-1">Hi {{ auth()->user()->name }},</p>
                        <p class="mb-2">Since 2017, I've running JOMWasap for free to help online seller boost their business but the features provided are only basic and maybe the that features you want aren't available.</p>
                        <p class="mb-2">Now I've planned to spend my time and energy to develop new JOMWasap with tons of new and exicting features to help boost your sales, saves your time and make it easier for prospect to contact you.</p>
                        <p>I'm planning to add tons of features that is exclusive to users that subscribed to JOMWasap but don't worry there'll be new features for free too.</p>
                        <hr>
                        <p class="mb-1">Please join this survey if you're interested to have access premium features for free for 1 month.</p>
                        <p class="mb-1">If you're interested, please visit this link and answer the survey <a href="https://forms.gle/CrfX2uBfA5MMam5r7">JOMWasap Survey</a>.</p>
                        <p class="mb-1">You may also join our Telegram support group to get help or request a new feature <a href="https://t.me/jomwasapmy">JOMWasap Support Group</a>.</p>
                    </div>
                    <div class="tab-pane fade" id="alert-malay" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <p class="mb-1">Hi {{ auth()->user()->name }},</p>
                        <p class="mb-2">Sejak 2017, saya telah melancarkan JOMWasap secara percuma untuk membantu memajukan bisnes untuk usahawan online tetapi ciri-ciri yang ditawarkan hanyalah asas sahaja dan mungkin banyak ciri yang anda inginkan tetapi tidak ditawarkan.</p>
                        <p class="mb-2">Sekarang saya telah memutuskan untuk memberikan masa dan tenaga saya untuk membangunkan JOMWasap yang baharu dengan ciri-ciri yang lebih baik supaya dapat membantu anda menaikkan sale, menjimatkan masa serta memudahkan prospek menghubungi anda.</p>
                        <p>Saya bercadang untuk menambah ciri-ciri baharu yang khas untuk pengguna yang melanggan JOMWasap dan jangan risau, akan ada juga ciri-ciri baharu secara percuma.</p>
                        <hr>
                        <p class="mb-1">Sila sertai survey ini sekiranya anda berminat untuk mendapatkan akses ciri-ciri premium secara percuma selama 1 bulan.</p>
                        <p class="mb-1">Sekiranya anda berminat, sila lawati link ini dan jawab soalan survey <a href="https://forms.gle/CrfX2uBfA5MMam5r7">JOMWasap Survey</a>.</p>
                        <p class="mb-1">Anda juga boleh sertai group support Telegram untuk mendapatkan bantuan atau ingin memberikan sebarang idea, <a href="https://t.me/jomwasapmy">JOMWasap Support Group</a>.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        Links Generated
                        <div class="float-right">
                            <a href="{{ route('generate.create') }}" class="btn btn-success btn-sm m-1">Create Links</a>
                            <br>
                            @if(Request::exists('delete'))
                            <a href="{{ route('generate.index') }}" class="btn btn-success btn-sm m-1">Active Links</a>
                            @else
                            <a href="{{ route('generate.index') }}?delete=1" class="btn btn-success btn-sm m-1">Archived Links</a>
                            @endif
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            #
                                        </th>
                                        <th scope="col">
                                            URL
                                        </th>
                                        <th scope="col">
                                            Info
                                        </th>
                                        <th scope="col">
                                            Type
                                        </th>
                                        <th scope="col">
                                            Mobile Number
                                        </th>
                                        <th scope="col">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($urls as $url)
                                    <tr>
                                        <th scope="row">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td>
                                            <a href="{{ url('https://hi.jomwasap.my/' . $url->alias) }}">{{ $url->alias }}</a>
                                            <div class="float-right">
                                                <button class="btn btn-secondary btn-sm" data-clipboard-text="{{ url('https://hi.jomwasap.my/' . $url->alias) }}">
                                                    <span class="fa fa-clipboard"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $url->info }}
                                        </td>
                                        <td>
                                            {{ ucfirst($url->type) }}
                                        </td>
                                        @if($url->type === 'single')
                                        <td>
                                            {{ $url->mobile_number }}
                                        </td>
                                        @else
                                        <td>
                                            @foreach($url->group->pluck('mobile_number')->toArray() as $number)
                                            {{ $number }}
                                            <br>
                                            @endforeach
                                        </td>
                                        @endif
                                        <td>

                                            <a href="{{ route('generate.show', $url->hashid) }}" class="btn btn-primary btn-sm">Show</a>
                                            <a href="{{ route('generate.edit', $url->hashid) }}" class="btn btn-info btn-sm">Edit</a>
                                            @if(Request::exists('delete'))
                                            <a href="{{ route('generate.restore', $url->hashid) }}" class="btn btn-success btn-sm">Restore</a>
                                            @else
                                            <a href="{{ route('generate.destroy', $url->hashid) }}" onclick="event.preventDefault(); document.getElementById('delete_form_{{$loop->iteration}}').submit() " class="btn btn-danger btn-sm">Delete</a>
                                            <form id="delete_form_{{$loop->iteration}}" style="display: none;" action="{{ route('generate.destroy', $url->hashid) }}" method="post">
                                                <input type="hidden" name="_method" value="delete">
                                                {{csrf_field()}}
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $urls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
