@extends('layouts.app')

@section('title')
    QuackNet - Accueil
@endsection

@section('content')
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if ($message = Session::get('success'))
                    <div class="container">
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    </div>
                @endif

                <div class="container-fluid mb-5">
                    <div class="row d-flex align-items-center mt-5 mb-4 border-bottom border-3 border-primary">
                        <div class="col-md-5 text-end">
                            <img class="mb-3" src="images/duck.png">
                        </div>
                        <div class="col-md-7 text-start">
                            <h1>QuackNet</h1>
                        </div>
                    </div>
                    <h2 class="mb-3">Bienvenue, {{ Auth::user()->pseudo }} !</h2>
                    <h5 class="font-weight-light">Viens quacker avec nous !</h5>
                </div>

                <!-- *************************************************AJOUTER UN QUACK**********************************************-->

                <div class="container">
                    <div class="row border rounded-pill border-warning p-4 mb-5 justify-content-center bg-warning">
                        <h3 class="mt-3">Ca se passe ici !</h3>

                        <form class="col-10 mx-auto m-4" action="{{ route('quacks.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <i class="fas fa-pen-fancy text-primary fa-2x me-2"></i><label for="content">écris un truc
                                    sympa (ou pas !)</label>
                                <textarea required class="container-fluid mt-2" type="text" name="content" id="content"
                                    placeholder="salut les canards !"></textarea>
                            </div>

                            <div class="row mt-4 mx-auto">
                                {{-- upload image --}}
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <i class="fas fa-upload fa-2x text-primary me-2"></i>Uploade ton image ici (max : 2
                                        Mo)
                                    </div>
                                    <div class="col-md-7">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 mx-auto">
                                <div class="col-md-5">
                                    <i class="fas fa-hashtag text-primary fa-2x me-2"></i><label class="label">ajoute
                                        des tags</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="tags" placeholder="salut">
                                </div>
                            </div>

                            <div class="d-grid w-50 mx-auto">
                                <button type="submit" class="btn btn-primary mt-4">Quack !</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <h2>Derniers quacks de nos quackiens</h2>

        <!-- **********************************************AFFICHER LES QUACKS**********************************************-->
        @foreach ($quacks as $quack)
            <div class="card mb-4 mt-5 pb-2">
                <div class="card-header bg-warning">
                    <div class="row">
                        <div class="col">
                            @if ($quack->user->image)
                                <img class="m-1 rounded-circle" style="width: 5vw; height:5vw"
                                    src="images/{{ $quack->user->image }}" alt="imageUtilisateur">
                            @else
                                <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="images/default_user.jpg"
                                    alt="imageUtilisateur">
                            @endif
                            <h5><a href="{{ route('user.profil', $quack->user_id) }}">
                                    <strong>{{ $quack->user->pseudo }}</strong>
                                </a>
                            </h5>
                        </div>
                        <div class="col m-auto">
                            <h4>#{{ implode(' #', explode(' ', $quack->tags)) }} </h4>
                        </div>
                        <div class="col m-auto">
                            <div class="row">posté {{ $quack->created_at->diffForHumans() }}</div>
                            @if ($quack->created_at != $quack->updated_at)
                                <div class="row">modifié {{ $quack->updated_at->diffForHumans() }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @if (isset($quack->image))
                    <div class="card-img p-3">
                        <img class="m-1" style="width: 45vw" src="images/{{ $quack->image }}" alt="imageQuack">
                    </div>
                @endif
                <div class="card-body ml-5 mr-5">
                    <p>{{ $quack->content }}</p>
                    <a href="{{ route('quacks.show', $quack) }}">Zoom sur ce quack</a>

                    <!-- **************************************OPTIONS : MODIFIER, COMMENTER ET SUPPRIMER******************************************-->
                    <div class="row mt-2">
                        <div class="col"><a class="btn btn-info"
                                onclick="document.getElementById('formulairecommentaire{{ $quack->id }}').style.display = 'block'">Commenter
                            </a>
                        </div>
                        {{-- @if (Auth::user()->can('update', $quack)) --}}
                            <div class="col">
                                <!--si l'utilisateur connecté a posté le quack, il peut le modifier et le supprimer-->
                                <a href="{{ route('quacks.edit', $quack) }}">
                                    <button class="btn btn-secondary">Modifier</button>
                                </a>
                            </div>
                        {{-- @endif --}}
                        @if (Auth::user()->can('delete', $quack))
                            <div class="col">
                                <form action="{{ route('quacks.destroy', $quack) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- **********************************************AJOUTER UN COMMENTAIRE**********************************************-->
                <div style="display:none" class="col p-3 mb-2" id="formulairecommentaire{{ $quack->id }}">
                    <form class="w-50 m-auto" action="{{ route('comments.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="content">Tape ton commentaire</label>
                            <textarea required class="container" type="text" name="content" id="content"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tags"># Ajoute des tags #</label>
                            <input required class="container" type="text" name="tags" id="tags"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4 form-group">
                                <label for="nom">image (facultatif)</label>
                                <input type="file" class="form-control" name="image" id="image"
                                    placeholder="upload d'image ci-dessous">
                            </div>
                            <input class="form-control" type="hidden" id="quack_id" name="quack_id"
                                value="{{ $quack->id }}">
                        </div>
                        <button class="btn btn-danger"
                            onclick="document.getElementById('formulairecommentaire{{ $quack->id }}').style.display = 'none'">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-warning">Valider</button>
                    </form>

                </div>
            </div>

            <!--                ***************************************modifier le quack******************************-->

            <form style="display:none;" id="formulairecommentaire{{ $quack->id }}" class="col-12 mx-auto mb-2"
                action="{{ route('quacks.update', $quack) }}" method="POST">
                @method('put')
                @csrf
                <div class="form-group">
                    <label for="content">Nouveau texte</label>
                    <input required type="text" class="form-control" name="content" value="{{ $quack->content }}"
                        id="content">
                </div>
                <div class="form-group">
                    <label for="image">Nouvelle image</label>
                    <input type="text" class="form-control" name="image" value="{{ $quack->image }}"
                        id="image">
                </div>
                <div class="form-group">
                    <label for="tags">Nouveaux tags</label>
                    <input type="text" class="form-control" name="tags" value="{{ $quack->tags }}"
                        id="tags">
                    <button type="submit" class="btn btn-primary">Valider</button>
            </form>
    </div>

    <!--****************************************afficher les commentaires****************************************-->

    @foreach ($quack->comments as $comment)
        <div class="container w-75 mb-4">
            <div class="card mb-2">

                <div class="card-header bg-primary text-light">
                    <div class="row">
                        <div class="col">
                            @if ($comment->user->image)
                                <img class="m-1 rounded-circle" style="width: 3vw; height:3vw"
                                    src="images/{{ $comment->user->image }}" alt="imageUtilisateur">
                            @else
                                <img class="m-1 rounded-circle" style="width: 3vw; height:3vw"
                                    src="images/default_user.jpg" alt="imageUtilisateur">
                            @endif
                            <h5><a style="text-decoration: none;" class="text-warning"
                                    href="{{ route('user.profil', $comment->user_id) }}">
                                    <strong>{{ $comment->user->pseudo }}</strong>
                                </a>
                            </h5>
                        </div>
                        <div class="col m-auto">
                            @if ($comment->tags !== null)
                                <h5>#{{ implode(' #', explode(' ', $comment->tags)) }} </h5>
                            @endif
                        </div>
                        <div class="col m-auto">
                            <div class="row">posté {{ $quack->created_at->diffForHumans() }}</div>
                            @if ($comment->created_at != $comment->updated_at)
                                <div class="row">modifié {{ $quack->updated_at->diffForHumans() }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{ $comment->content }}
                    @if ($comment->image !== null)
                        <div class="card-img p-3">
                            <img style="width: 15vw" src="images/{{ $comment->image }}" alt="imageQuack">
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

    <div class="col-md-2 offset-md-5">
        {{ $quacks->links() }}
    </div>

    </div>
    </div>
    </div>
@endsection
