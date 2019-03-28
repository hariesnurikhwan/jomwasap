<!DOCTYPE html>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/align.css') }}" rel="stylesheet">


    @isset($url)
        @include('partials.customFacebookMeta')
    @else
        @include('partials.facebookMeta')
    @endisset

    <script>
        window.Laravel = {!!json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

</head>
<body>

    <div id="app">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand ml-3" href="{{ url('/') }}">
            <img height="50" src="{{ asset('images/logo.png') }}" alt="JOMWasap">
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'generate' ? 'active' : '' }}" href="{{ route('generate.index') }}">My Links</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu nav-dropdown" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault()
                        document.getElementById('logout-form').submit()"
                        >Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{csrf_field()}}
                        </form>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </nav>
    <br>
</div>
@yield('content')

<footer class="footer mt-2 fixed-bottom bg-light">
    <div class="container-fluid p-0">
        <div class="bg-light p-3">
            <p class="navbar-text float-right">
                Developed By <a href="https://fb.me/hariesnurikhwan" target="_blank" >Haries Nur Ikhwan</a>
            </p>
        </div>
    </div>
</footer>
@isset($url->facebook_pixel)
    @include('partials.facebookPixel')
@endisset
@include('partials.googleAnalytics')
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
