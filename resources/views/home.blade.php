@extends('layout.app')

@section('title')
Accueil
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <a href="quacks/create">
                <button class="btn btn-primary mb-3">Poster un quack</button>
            </a>

            @foreach ($quacks as $quack)
            @if(session()->has('message'))
            <p class="alert alert-success">{{ session()->get('message') }}</p>
            @endif
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4"><b>{{ $quack->user->duckname }}</b></div>
                        @if ($quack->created_at != $quack->updated_at)
                        <div class="col-4"> modifié le {{ $quack->updated_at }}</div>
                        @else
                        <div class="col-4"></div>
                        @endif
                        <div class="col-4"> posté le {{ $quack->created_at }}</div>
                    </div>
                </div>
                <div class="card-img mt-3">
                    <!--                        <img src="{{url('/public/images/-->
                    <?php //echo $quack->image; ?><!--')}}" alt="canard">-->
                    <img class="w-25" src="/images/canard.jpg" alt="canard">
                </div>
                <div class="card-body">
                    <div>{{ $quack->content }}</div>
                    <div class="row">
                        <div class="col-4">{{ $quack->tags }}</div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a href="{{ route('quacks.destroy', $quack->id) }}">
                                <button class="btn btn-danger">Supprimer</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection

