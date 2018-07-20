@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                 View "{{ $url->alias }}" Link Content.
                 <a href="{{ route('generate.edit', $url->hashid) }}" class="btn btn-success btn-xs pull-right">Edit Link</a>
             </div>
             <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt>URL</dt>
                    <dd>
                        https://hi.jomwasap.my/{{ $url->alias }}
                        <div class="pull-right">
                            @if(env('APP_ENV') === 'local')
                            <button class="btn btn-info btn-xs" data-clipboard-text="{{ url(env('APP_URL') . ':8000/go/' . $url->alias) }}">
                                Copy
                            </button>
                            @else
                            <button class="btn btn-info btn-xs" data-clipboard-text="{{ url('https://hi.jomwasap.my/' . $url->alias) }}">
                                Copy
                            </button>
                            @endif
                        </div>
                    </dd>
                    @if($url->type === 'single')
                    <dt>Mobile Number</dt>
                    <dd>{{ phone($url->mobile_number, 'MY') }}</dd>
                    @elseif($url->type === 'group')
                    <dt>Mobile Numbers</dt>
                    @foreach($url->group->pluck('mobile_number') as $number)
                    <dd>{{phone($number, 'MY')}}</dd>
                    @endforeach
                    @endif
                    <dt>Pretext Chat</dt>
                    <dd><pre>{{ $url->text }}</pre></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
