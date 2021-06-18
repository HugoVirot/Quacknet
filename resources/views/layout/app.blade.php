<html lang="fr">

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="/js/app.js"></script>
    <link rel="icon" href="{{ asset("images/duck.png") }}">
</head>

<header class="text-center">
    <nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand ml-2" href="{{ url('/home') }}"><img style="height: 40px; width: 40px;" src="{{ asset("images/duck.png") }}" alt="logo">
                {{ config('QuackNet', 'QuackNet') }}
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
                    @guest
                    <!--si user pas connecté : login et register-->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('connexion') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('inscription') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown mr-4">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->duckname }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user.profil', $user = Auth::user()->id) }}">{{ __('Mon profil') }}</a>
                            <a class="dropdown-item" href="{{ route('user.account') }}">{{ __('Mon compte') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Se déconnecter') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
        <form class="row mt-2 mr-2" action="{{ route('quacks.search') }}" method="get" role="search">
            <div class="input-group">
                <input type="search" class="form-control" name="q" id="recherche" placeholder="Rechercher un Quack">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Go !</button>
                </span>
            </div>
        </form>
    </nav>
</header>

<body class="text-center">

    <div class="container-fluid text-center">
        @if(session()->has('message'))
        <p class="alert alert-success">{{ session()->get('message') }}</p>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    @yield('content')

</body>

<footer class="text-center bg-warning p-5 mt-5">
    <p>© QuackNet 2020 - codé par des canards pour des canards</p>
</footer>

</html>