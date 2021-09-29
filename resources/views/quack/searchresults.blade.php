@extends('layout.app')

@section('title')
    QuackNet - Résultats de la recherche
@endsection

@section('content')
    <div class="container">
        <h2 class="mb-5">Résultats de la recherche</h2>

        @if (count($quacks) == 0)
            <img style="width: 25vw" src="/images/lost_duck.jpg" alt="lost duck">
            <h5 class="p-4">Aucun quack ne correspond à votre recherche...</h5>

        @else

            @foreach ($quacks as $quack)
                <div class="card mb-4 mt-5 pb-2">
                    <div class="card-header bg-warning">
                        <div class="row">
                            <div class="col">
                                {{-- @if ($quack->user->image !== null) --}}
                                {{-- <img class="m-1 rounded-circle" style="width: 5vw; height:5vw"  src="images/{{ $quack->user->image }}" alt="imageUtilisateur"> --}}
                                {{-- @else --}}
                                <img class="m-1 rounded-circle" style="width: 5vw; height:5vw"
                                    src="{{ asset('images/default_user.jpg') }}" alt="imageUtilisateur">
                                {{-- @endif --}}
                                <h5><a href="{{ route('user.profil', $quack->user->id) }}">
                                        <strong>{{ $quack->user->duckname }}</strong>
                                    </a>
                                </h5>
                            </div>
                            <div class="col m-auto">
                                <h4>#{{ $quack->tags }} </h4>
                            </div>
                            <div class="col m-auto">
                                <div class="row">posté {{ $quack->created_at->diffForHumans() }}</div>
                                @if ($quack->created_at != $quack->updated_at)
                                    <div class="row">modifié {{ $quack->updated_at->diffForHumans() }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($quack->image !== null)
                        <div class="card-img p-3">
                            <img class="m-1" style="width: 45vw" src="{{ asset("images/$quack->image") }}"
                                alt="imageQuack">
                        </div>
                    @endif
                    <div class="card-body ml-5 mr-5">
                        <p>{{ $quack->content }}</p>
                        <a href="{{ route('quacks.show', $quack->id) }}">Zoom sur ce quack</a>
                    </div>
                </div>

                @foreach ($quack->comments as $comment)
                    <div class="container w-75 mb-4">
                        <div class="card mb-2">

                            <div class="card-header bg-primary text-light">
                                <div class="row">
                                    <div class="col">
                                        {{-- @if ($comment->user->image !== null) --}}
                                            {{-- <img class="m-1 rounded-circle" style="width: 3vw; height:3vw"
                                                src="images/{{ $comment->user->image }}" alt="imageUtilisateur">
                                        @else --}}
                                            <img class="m-1 rounded-circle" style="width: 3vw; height:3vw"
                                                src="{{ asset("images/default_user.jpg") }}" alt="imageUtilisateur">
                                        {{-- @endif --}}
                                        <h5><a style="text-decoration: none;" class="text-warning"
                                                href="{{ route('user.profil', $comment->user_id) }}">
                                                <strong>{{ $comment->user->duckname }}</strong>
                                            </a>
                                        </h5>
                                    </div>
                                    <div class="col m-auto">
                                        @if ($comment->tags !== null)
                                            <h5>#{{ $comment->tags }} </h5>
                                        @endif
                                    </div>
                                    <div class="col m-auto">
                                        <div class="row">posté {{ $quack->created_at->diffForHumans() }}
                                        </div>
                                        @if ($comment->created_at != $comment->updated_at)
                                            <div class="row">modifié
                                                {{ $quack->updated_at->diffForHumans() }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                {{ $comment->content }}
                                @if ($comment->image !== null)
                                    <div class="card-img p-3">
                                        <img style="width: 15vw" src="{{ asset("images/$comment->image") }}" alt="imageComment">
                                    </div>
                                @endif
                                <div class="row mb-2">
                                    @can('update', $comment)
                                        <div class="col">
                                            <a href="{{ route('comments.edit', $comment) }}">
                                                <button class="btn btn-secondary">Modifier</button>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('delete', $comment)
                                        <!--            si l'utilisateur connecté est l'auteur du quack ou du commentaire, il peut supprimer le commentaire -->
                                        <div class="col">
                                            <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endforeach

        @endif
    </div>

@endsection
