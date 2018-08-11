@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="mt-5 col-md-4 col-lg-4 col-sm-12">
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <a platform="web" href="{{ $redirectWeb }}" class="btn btn-primary">WhatsApp for Web</a>
                </div>
                <div class="p-2 bd-highlight">
                    <a platform="os" href="{{ $redirectApp }}" class="btn btn-primary">WhatsApp for {{ $os }} </a>
                </div>
            </div>
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <small>* Click WhatsApp for Web if you don't have WhatsApp for {{ $os }}.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-9302574947880224"
        data-ad-slot="2478351390"
        data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>
@endsection
