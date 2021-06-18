@extends ('layout.app')

@section('title')
QuackNet - Zoom sur le Quack
@endsection

@section('content')
<div class="container">
    <div class="card mb-2">
        <div class="card-header bg-warning">
            <div class="row">
                <div class="col">
                    <a href="{{ route ('user.profil', $quack->user_id) }}">
                        <strong>{{ $quack->user->duckname }}</strong>
                    </a>
                </div>
                <div class="col">#{{ $quack->tags }}</div>
                @if ($quack->created_at != $quack->updated_at)
                <div class="col"> modifié le {{ $quack->updated_at }}</div>
                @endif
                <div class="col"> posté le {{ $quack->created_at }}</div>
            </div>
        </div>
        @if (isset ($quack->image))
        <div class="card-img p-3">
            <img class="w-50 m-3" src="{{ asset("images/$quack->image") }}" alt="imageQuack">
        </div>
        @endif

        <div class="card-body p-3">
            <div>{{ $quack->content }}</div>
            <div class="row mt-2">
                <div class="col-4"></div>
            </div>

            <!-- **************************************OPTIONS : COMMENTER ET SUPPRIMER******************************************-->
            @if (Auth::check())
            {{-- tous les users connectés peuvent commenter le quack (pas ceux non-connectés)--}}
            <div class="row mb-2 mt-2">
                <div class="col"><a class="btn btn-primary" onclick="document.getElementById('formulairecommentaire{{$quack->id}}').style.display = 'block'">Commenter
                    </a>
                </div>
                @can('update', $quack)
                <div class="col">
                    <!-- si l'utilisateur connecté a posté le quack, il peut le modifier et le supprimer-->

                    <a href="{{ route('quacks.edit', $quack) }}">
                        <button class="btn btn-secondary">Modifier</button>
                    </a>
                </div>
                @endcan
                @can('delete', $quack)
                <div class="col">
                    <!-- user = auteur ou modérateur : il peut supprimer le quack-->
                    <form action="{{ route('quacks.destroy', $quack) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
                @endcan
            </div>
        </div>
    </div>
    @endif
</div>

<!-- **********************************************AJOUTER UN COMMENTAIRE**********************************************-->
<form style="display:none;" id="formulairecommentaire{{$quack->id}}" class="container w-50 mx-auto mb-4" action="{{ route('comments.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="content">Tapez votre message</label>
        <textarea required class="container-fluid" type="text" name="content" id="content"></textarea>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 form-group">
            <label for="nom">image (facultatif)</label>
            <input type="text" class="form-control" name="image" id="image">
        </div>
        <input class="form-control" type="hidden" id="quack_id" name="quack_id" value="{{$quack->id}}">
    </div>
    <button class="btn btn-danger" onclick="document.getElementById('formulairecommentaire{{$quack->id}}').style.display = 'none'">
        Annuler
    </button>
    <button type="submit" class="btn btn-warning">Valider</button>
</form>
</div>
@foreach($quack->comments as $comment)
<div class="container w-50">
    <div class="card mb-2">
        <div class="card-header text-light bg-primary">
            <div class="row">
                <div class="col">{{$comment->user->duckname}}</div>
                <div class="col">posté le {{$comment->created_at}}</div>
            </div>
        </div>
        <div class="card-body">
            {{ $comment->content }}
            @if (isset ($comment->image))
            <div class="card-img p-3">
                <img style="width: 15vw" src="{{ asset("images/$quack->image") }}" alt="imageQuack">
            </div>
            @endif
            <div class="row mb-2">
                @can('update', $comment)
                <div class="col">
                    <a href="{{ route('comments.edit', $comment) }}">
                        <button class="btn btn-secondary">Modifier</button>
                    </a></div>
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
@endsection