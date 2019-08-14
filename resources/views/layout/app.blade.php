<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="/js/app.js"></script>
{{--    <link rel="icon" href="{{ asset("images/logo_sans_texte.png") }}">--}}
</head>
<body class="container-fluid text-center">
<nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm mb-5">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('Quack', 'Quack') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest                                                        <!--si user pas connecté : login et register-->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('connexion') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('inscription') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->duckname }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.account') }}">{{ __('Mon compte') }}</a>
                        </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@yield('content')

</body>
</html>
