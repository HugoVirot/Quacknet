@extends('layout.app')

@section('title')
QuackNet - Résultats de la recherche
@endsection

@section('content')
<div class="container">
    <h2 class="mb-5">Résultats de la recherche</h2>

    @if(count($quacks) == 0)
    <img style="width: 25vw" src="/images/lost_duck.jpg" alt="lost duck">
    <h5 class="p-4">Aucun quack ne correspond à votre recherche...</h5>

    @else

    @foreach($quacks as $quack)
    <div class="card mb-4 mt-5 pb-2">
        <div class="card-header bg-warning">
            <div class="row">
                <div class="col">
                    @if($quack->userimage !== null)
                    <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="{{ asset("images/$quack->userimage") }}" alt="imageUtilisateur">
                    @else
                    <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="{{ asset("images/default_user.jpg") }}" alt="imageUtilisateur">
                    @endif
                    <h5><a href="{{ route ('user.profil', $quack->user_id) }}">
                            <strong>{{ $quack->duckname }}</strong>
                        </a>
                    </h5>
                </div>
                <div class="col m-auto">
                    <h4>#{{ $quack->tags }} </h4>
                </div>
                <div class="col m-auto">
                    <div class="row">posté le {{date('d/m/Y à H:i', strtotime($quack->created_at))}}</div>
                    @if ($quack->created_at != $quack->updated_at)
                    <div class="row">modifié le {{date('d/m/Y à H:i', strtotime($quack->updated_at))}}</div>
                    @endif
                </div>
            </div>
        </div>
        @if ($quack->image !== null)
        <div class="card-img p-3">
            <img class="m-1" style="width: 45vw" src="{{ asset("images/$quack->image") }}" alt="imageQuack">
        </div>
        @endif
        <div class="card-body ml-5 mr-5">
            <p>{{ $quack->content }}</p>
            <a href="{{ route('quacks.show', $quack->id) }}">Zoom sur ce quack</a>
        </div>
    </div>

    @endforeach

    @endif
</div>

@endsection