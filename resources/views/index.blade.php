<html>
<head>
    <title>Bienvenue sur Quack !</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="container-fluid text-center">
<nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm mb-5">
        <a class="navbar-brand ml-5" href="{{ url('/home') }}">
            {{ config('Quack', 'Quack') }}
        </a>
</nav>
<div class="pl-5 container w-50 border border-dark p-3">
    <div class="row">
        <div class="pb-3">
            <h2 class="ml-5">Bienvenue sur Quack !</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-6"><a href="login"><button class="btn btn-primary">Connexion</button></a></div>
        <div class="col-6"><a href="register"><button class="btn btn-primary">Inscription</button></a></div>
    </div>
</div>

</body>
</html>
