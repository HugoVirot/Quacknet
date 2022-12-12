@extends ('layouts.app')

@section('title')
Mon compte
@endsection

@section('content')
<div class="container mb-4">
    <h3>Mes informations </h3>
    <a href="{{route('user.account.edit')}}"><button class="btn btn-primary mb-2">modifier les informations</button></a>
    <form action="{{route('user.destroy', $user)}}" method="post">
        @csrf
        @method("delete")
        <button type="submit" class="btn btn-danger">supprimer le compte</button>
    </form>
</div>
<div class="container w-50 border border-dark p-4">
    @if($user->image)
    <div class="col">
        <img src="{{ asset("images/$user->image") }} " class="m-1 rounded-circle" style="width: 10vw; height:10vw" alt="imageUtilisateur">
    </div>
    @else
    <img src="{{ asset("images/default_user.jpg") }} " class="m-1 rounded-circle" style="width: 20vw; height:20vw" alt="imageUtilisateur">
    @endif
    <div class="row">
        <div class="col-6">
            <p>pseudo : </p>
        </div>
        <div class="col-6"><b>{{ $user->pseudo }}</b></div>
    </div>
    <div class="row">
        <div class="col-6">
            <p>e-mail : </p>
        </div>
        <div class="col-6">
            <p>{{ $user->email }}</p>
        </div>
    </div>
</div>
@endsection