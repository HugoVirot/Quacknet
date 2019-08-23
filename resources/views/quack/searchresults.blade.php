@extends('layout.app')

@section('title')
    QuackNet - Résultats de la recherche
@endsection

@section('content')

    <div class="container">
        <h2 class="mb-5">Résultats de la recherche</h2>
        @foreach($quacks as $quack)
            <div class="card mb-3">
                <div class="card-header">posté le <strong>{{ $quack->created_at }}</strong>
                    par l'utilisateur n° <strong>{{ $quack->user_id }}</strong></div>
                <div class="card-body">
                    <div>contenu du quack : <strong>{{ $quack->content }}</strong></div>
                    <div class="mb-2">tags du quack : <strong>{{ $quack->tags }}</strong></div>
                    <a href="{{ route ('quacks.show', $quack->id) }}">Zoom sur ce quack</a>
                </div>
            </div>
        @endforeach
    </div>

@endsection

