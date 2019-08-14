@extends ('layout.app')

@section('title')
    Mon compte
@endsection

@section('content')
    <div class="container">
        <div class="container mb-4">
                <h3>Mes informations </h3>
            <a href="{{route('user.updateaccount')}}"><button class="btn btn-primary">modifier les informations</button></a>
        </div>
    </div>
    <div class="container w-50 border border-dark p-3">
        <div class="row">
            <div class="col-6"><p>Prénom : </p></div>
            <div class="col-6"><b>{{ $user->prenom }}</b></div>
        </div>
        <div class="row">
            <div class="col-6"><p>Nom : </p></div>
            <div class="col-6"><b>{{ $user->nom }}</b></div>
        </div>
        <div class="row">
            <div class="col-6"><p>Duckname : </p></div>
            <div class="col-6"><b>{{ $user->duckname }}</b></div>
        </div>
        <div class="row">
            <div class="col-6"><p>e-mail : </p></div>
            <div class="col-6"><p>{{ $user->email }}</p></div>
        </div>
    </div>
    </div>








@endsection
