@extends('layouts.app')

@section('content') 
    <div class="container-fluid text-center">
        @if (session()->has('message'))
            <p class="alert alert-success">{{ session()->get('message') }}</p>
        @endif
    </div>

    <div class="container m-5 p-5 mx-auto">

        <div class="row d-flex align-items-center mt-5 mb-4">
            <div class="col-md-5">
                <img class="mb-3 w-50" src="images/duck.png">
            </div>
            <div class="col-md-7 text-start">
                <h1>Bienvenue sur QuackNet !</h1>
            </div>
        </div>

        <div class="row mt-5 w-50 mx-auto">
            <div class="col-6">
                <a href="login"><button class="btn btn-lg px-5 btn-primary">Connexion</button></a>
            </div>
             <div class="col-6">
                <a href="register"><button class="btn btn-lg px-5 btn-primary">Inscription</button></a>
        </div>
    </div>
    </div>
@endsection

</body>

</html>
