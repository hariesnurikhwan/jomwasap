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
    <div class="row">
    	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- JOMWasap -->
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
