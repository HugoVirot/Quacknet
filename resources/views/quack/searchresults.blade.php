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
    <div class="card mb-3">
        <div class="card-header">posté le <strong>{{ $quack->created_at }}</strong>
            par <strong>{{ $quack->duckname }}</strong></div>
        <div class="card-body">
        <img src="{{ asset('images/$quack->image') }}">
            <div>contenu du quack : <strong>{{ $quack->content }}</strong></div>
            <div class="mb-2">tags du quack : <strong>#{{ $quack->tags }}</strong></div>
            <a href="{{ route ('quacks.show', $quack->id) }}">Zoom sur ce quack</a>
        </div>
    </div>
    @endforeach
    @endif
</div>

@endsection