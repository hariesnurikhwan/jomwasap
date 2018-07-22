@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Links Generated
                    <a href="{{ route('generate.create') }}" class="btn btn-success btn-xs pull-right">Create Links</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>URL</th>
                                    <th>Type</th>
                                    <th>Mobile Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($urls as $url)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ url('https://hi.jomwasap.my/' . $url->alias) }}
                                        <div class="pull-right">
                                            <button class="btn btn-info btn-xs" data-clipboard-text="{{ url('https://hi.jomwasap.my/' . $url->alias) }}">
                                                <span class="glyphicon glyphicon-copy"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ ucfirst($url->type) }}</td>
                                    @if($url->type === 'single')
                                    <td>{{ $url->mobile_number }}</td>
                                    @else
                                    <td>
                                        @foreach($url->group->pluck('mobile_number')->toArray() as $number)
                                        {{$number}}
                                        <br>
                                        @endforeach
                                    </td>
                                    @endif
                                    <td>
                                        <a href="{{ route('generate.show', $url->hashid) }}" class="btn btn-primary btn-xs">Show</a>
                                        <a href="{{ route('generate.edit', $url->hashid) }}" class="btn btn-warning btn-xs">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pull-right">
                    {{ $urls->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
