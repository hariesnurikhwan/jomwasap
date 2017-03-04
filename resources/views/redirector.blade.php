@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
           <div class="flexbox-container">
                <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 col-md-offset-4 col-lg-offset-4">
                    <a href="{{ $redirectWeb }}" class="btn btn-primary">WhatsApp for Web</a>
                    <a href="{{ $redirectApp }}" class="btn btn-primary">WhatsApp for {{ $os }}</a>
                    <p>* Click WhatsApp for Web if you don't have WhatsApp for {{ $os }}.</p>
                </div>
       </div>
    </div>
</div>
@endsection
