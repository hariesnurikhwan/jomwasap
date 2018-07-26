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
                            <button class="btn btn-info btn-xs" data-clipboard-text="{{ url('https://hi.jomwasap.my/' . $url->alias) }}">
                                <span class="glyphicon glyphicon-copy"></span>
                            </button>
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
                    <dt>Lead Capture</dt>
                    <dd>{{$url->enable_lead_capture ? "Enabled" : "Disabled"}}</dd>
                    <dt>Pretext Chat</dt>
                    <dd><pre>{{ $url->text }}</pre></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
