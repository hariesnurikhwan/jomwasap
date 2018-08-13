@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        Links Generated
                        <a href="{{ route('generate.create') }}" class="btn btn-success btn-sm float-right">Create Links</a>
                    </div>
                    <div class="card-body">
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
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form').submit() " class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                    <form id="delete_form" style="display: none;" action="{{ route('generate.destroy', $url->hashid) }}" method="post">
                                        <input type="hidden" name="_method" value="delete">
                                        {{csrf_field()}}
                                    </form>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $urls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
