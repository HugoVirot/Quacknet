<html>
<head>
    <title>Bienvenue sur Quack !</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="container-fluid text-center mt-5">
<img class="mb-5 mt-5" src="{{ asset("images/duck.png") }}" alt="logo">
<div class="pl-5 container w-50 border border-dark p-5">
    <div class="row justify-content-center text-center ">
        <div class="pb-5">
            <h2>Bienvenue sur QuackNet !</h2>
        </div>
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col"><a href="login"><button class="btn btn-primary">Connexion</button></a></div>
        <div class="col"><a href="register"><button class="btn btn-primary">Inscription</button></a></div>
        <div class="col"></div>
    </div>
</div>

</body>
</html>
