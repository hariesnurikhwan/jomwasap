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

    <!-- Scripts -->

    <script>
        window.Laravel = {!!json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>

</head>
<body>
    <div id="app">
        <div id="wrapper">
            <div id="nav-wrapper">
                <nav id="sidebar-wrapper" role="navigation">
                    <ul class="nav sidebar-nav">
                        <li class="sidebar-brand">
                            <a href="#">JOM Wasap</a>
                        </li>
                        @if(Auth::guest())
                        <li>
                            <a href="/login">Login</a>
                        </li>
                        <li>
                           <a href="/register">Register</a>
                       </li>
                       @else
                       <li>
                        <a href="/">Dashboard</a>
                    </li>
                    <li>
                        <a href="/generate">Generate</a>
                    </li>
                    <li>
                        <a href="#">Marketing Campaign</a>
                    </li>
                    <li>
                        <a v-on:click.prevent="logout" href="{{ route('logout') }}">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{csrf_field()}}
                        </form>
                    </li>
                    @endif
                </ul>
            </nav>
            <button v-on:click.prevent="hamburger_cross()" type="button" class="hamburger is-closed">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
        </div>
        <div id="page-content-wrapper">
            @yield('content')
        </div>
    </div>
</div>

@push('scripts')
<script>
    new Vue({
        el: '#nav-wrapper',
        data: {
            isClosed: false,
        },
        methods: {

            logout: function() {
                $('#logout-form').submit();
            },
            hamburger_cross: function() {
                trigger = $('.hamburger');
                overlay = $('.overlay');
                wrapper = $('#wrapper');

                if (this.isClosed) {
                    overlay.hide();
                    trigger.removeClass('is-open');
                    trigger.addClass('is-closed');
                    this.isClosed = false;
                } else {
                    overlay.show();
                    trigger.removeClass('is-closed');
                    trigger.addClass('is-open');
                    this.isClosed = true;
                }

                $('#wrapper').toggleClass('toggled');
            }
        },
        mounted: function() {

        }
    })
</script>
@endpush



    {{-- <footer class="footer mt-2 fixed-bottom bg-light">
        <div class="container-fluid p-0">
            <div class="bg-light p-3">
                <p class="navbar-text float-right">
                    Developed By <a href="https://fb.me/hariesnurikhwan" target="_blank" >Haries Nur Ikhwan</a>
                </p>
            </div>
        </div>
    </footer> --}}
    @include('partials.googleAnalytics')
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
