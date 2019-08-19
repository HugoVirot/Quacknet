@extends('layout.app')

@section('title')
Accueil
@endsection

@section('content')
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <a href="quacks/create">
                <button class="btn btn-primary mb-3">Poster un quack</button>
            </a>
            @if(session()->has('message'))
            <p class="alert alert-success">{{ session()->get('message') }}</p>
            @endif
            @foreach ($quacks as $quack)
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route ('user.profil', $quack->user_id) }}">
                                <strong>{{ $quack->user->duckname }}</strong>
                            </a>
                        </div>
                        @if ($quack->created_at != $quack->updated_at)
                        <div class="col"> modifié le {{ $quack->updated_at }}</div>
                        @else
                        <div class="col"></div>
                        @endif
                        <div class="col"> posté le {{ $quack->created_at }}</div>
                    </div>
                </div>
                <div class="card-img mt-3">
                    <!--                        <img src="{{url('/public/images/-->
                    <?php //echo $quack->image; ?><!--')}}" alt="canard">-->
                    <img class="w-25" src="/images/canard.jpg" alt="canard">
                </div>
                <div class="card-body">
                    <div>{{ $quack->content }}</div>
                    <div class="row mt-2">
                        <div class="col">{{ $quack->tags }}</div>
                        <div class="col"><a class="btn btn-primary" href="{{ route('quacks.destroy', $quack->id) }}">Commenter</a></div>
                        <div class="col">
                            @if ($quack->user_id == Auth::user()->id)
                            <form action="{{ route('quacks.destroy', $quack) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                            @endif
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

