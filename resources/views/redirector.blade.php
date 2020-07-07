@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="mt-5 col-md-4 col-lg-4 col-sm-12">
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <a href="{{ $redirectWeb }}" class="btn btn-primary">WhatsApp for Web</a>
                </div>
                <div class="p-2 bd-highlight">
                    <a href="{{ $redirectApp }}" class="btn btn-primary">WhatsApp for {{ $os }} </a>
                </div>
            </div>
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <small>* Click WhatsApp for Web if you don't have WhatsApp for {{ $os }}.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
