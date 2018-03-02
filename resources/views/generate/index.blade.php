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
                                    <td>#</td>
                                    <td>URL</td>
                                    <td>Mobile Number</td>
                                    <td>Actions</td>
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
                                                    Copy
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{ $url->mobile_number }}</td>
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
