@extends ('layout.app')

@section('title')
profil
@endsection

@section('content')
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container-fluid text-center p-3">
                <div class="col">
                    @if($user->image)
                    <img src="{{ asset("images/$user->image") }} " class="m-1 rounded-circle" style="width: 20vw; height:20vw" alt="imageUtilisateur">
                    @else
                    <img src="{{ asset("images/default_user.jpg") }} " class="m-1 rounded-circle" style="width: 20vw; height:20vw" alt="imageUtilisateur">
                    @endif
                </div>
                <div class="col pt-3">bienvenue sur le profil de <h1 class="font-weight-bold text-warning">{{ $user->duckname }}</h1>
                </div>
                <div class="row mb-2">
                    <div class="col">alias <b>{{ $user->prenom }} {{ $user->nom }}<b></div>
                </div>

                <div class="row justify-content-center">
                    <div>inscrit(e) le {{ date('d-m-Y', strtotime($user->created_at)) }} - {{ count($user->quacks) }} quack(s) postés </div>
                </div>

                <!-- ***********************************AFFICHER LES QUACKS*****************************-->

                @foreach ($user->quacks as $quack)
                <div class="card mb-4 mt-5 pb-2">
                <div class="card-header bg-warning">
                    <div class="row">
                        <div class="col">
                            @if($user->image)
                            <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="{{ asset("images/$user->image") }}" alt="imageUtilisateur">
                            @else
                            <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="images/default_user.jpg" alt="imageUtilisateur">
                            @endif
                            <h5><a href="{{ route ('user.profil', $quack->user_id) }}">
                                    <strong>{{ $user->duckname }}</strong>
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
                @if (($quack->image !== null))
                <div class="card-img p-3">
                    <img class="m-1" style="width: 45vw" src="{{ asset("images/$quack->image") }}" alt="imageQuack">
                </div>
                @endif
                <div class="card-body ml-5 mr-5">
                    <p>{{ $quack->content }}</p>
                    <a href="{{ route('quacks.show', $quack) }}">Zoom sur ce quack</a>



                        <!--  ******************************OPTIONS : MASQUER, COMMENTER, MODIFIER, SUPPRIMER******************   -->
                        <div class="row mt-2">
                            <div class="col"><a class="btn btn-info" onclick="document.getElementById('formulairecommentaire{{$quack->id}}').style.display = 'block'">Commenter
                                </a>
                            </div>
                            <!-- si l'utilisateur connecté a posté le quack, il peut le modifier et le supprimer-->
                            @if ($quack->user_id == Auth::user()->id)
                            <div class="col">
                                <a href="{{ route('quacks.edit', $quack) }}">
                                    <button class="btn btn-secondary">Modifier</button>
                                </a>
                            </div>
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
                </div>

                <!-- **********************************************AJOUTER UN COMMENTAIRE**********************************************-->
                <form style="display:none;" id="formulairecommentaire{{$quack->id}}" class="col-12 mx-auto mb-2" action="{{ route('comments.store') }}" method="POST">
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


                <!--                ***************************************modifier le quack******************************-->

                <!-- <form style="display:none;" id="formulairecommentaire{{$quack->id}}" class="col-12 mx-auto mb-2" action="{{ route('quacks.update', $quack) }}" method="POST">
                    @method("put")
                    @csrf
                    <div class="form-group">
                        <label for="content">Nouveau texte</label>
                        <input required type="text" class="form-control" name="content" value="{{ $quack->content }}" id="content">
                    </div>
                    <div class="form-group">
                        <label for="image">Nouvelle image</label>
                        <input type="text" class="form-control" name="image" value="{{ $quack->image }}" id="image">
                    </div>
                    <div class="form-group">
                        <label for="tags">Nouveaux tags</label>
                        <input type="text" class="form-control" name="tags" value="{{ $quack->tags }}" id="tags">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form> -->

                <!-- ********************************************* AFFICHER LES COMMENTAIRES **********************************************-->

                @foreach($quack->comments as $comment)
                <div class="container w-75">
                    <div class="card mb-2">
                        <div class="card-header text-light bg-primary">
                            <div class="row">
                                <div class="col">{{$comment->user->duckname}}</div>
                                <div class="col">posté le {{$comment->created_at}}</div>
                            </div>
                        </div>
                        <div class="card-body">{{ $comment->content }}
                            @if ($quack->user_id === Auth::id() || $comment->user_id === Auth::id())
                            <!--            si l'utilisateur connecté est l'auteur du quack ou du commentaire, il peut supprimer le commentaire -->
                            <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger mt-3">Supprimer</button>
                            </form>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach

                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection