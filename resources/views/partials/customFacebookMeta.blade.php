<meta property="og:url" content="{{ request()->url() }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $url->title }}" />
<meta property="og:description" content="{{ $url->description }}" />
<meta property="og:image" content="{{ asset('images/og/' . $url->alias) }}" />
