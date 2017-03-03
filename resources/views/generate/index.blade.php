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
                                        <td>{{ url('https://hi.jomwasap.my/' . $url->alias) }} <a href="https://hi.jomwasap.my/{{ $url->alias }}" class="label label-success pull-right">Visit</a></td>
                                        <td>{{ $url->mobile_number }}</td>
                                        <td>
                                            <a href="{{ route('generate.show', $url->id) }}" class="btn btn-primary btn-xs">Show</a>
                                            <a href="{{ route('generate.edit', $url->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
