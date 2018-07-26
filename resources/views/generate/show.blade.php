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
                    @if($url->text)
                    <dt>Pretext Chat</dt>
                    <dd><pre>{{ $url->text }}</pre></dd>
                    @endif
                </dl>
            </div>
            <hr>
            <div class="panel-body">
                <h4>Leads Captured</h4>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                    </tr>
                    @foreach($url->lead as $lead)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$lead->name}}</td>
                        <td>{{$lead->mobile_number}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
