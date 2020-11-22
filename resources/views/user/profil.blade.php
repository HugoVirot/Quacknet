@extends ('layout.app')

@section('title')
    profil
@endsection

@section('content')

    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="container-fluid text-center">
                    <div class="col">profil de : <h1>{{ $user->duckname }}</h1></div>
                    <div class="row mb-2">
                        <div class="col">Prénom : {{ $user->prenom }}, nom : {{ $user->nom }}</div>
                    </div>
                    {{-- ***********************************AFFICHER LES QUACKS*****************************               --}}
                    @foreach ($user->quacks as $quack)
                            <div class="card mb-1">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ route ('user.profil', $quack->user_id) }}">
                                                <strong>{{ $user->duckname }}</strong>
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
                                    </div>

                                    {{-- ******************************OPTIONS : MASQUER, COMMENTER, MODIFIER, SUPPRIMER******************               --}}
                                    <div class="row mt-2">
                                        @if (Auth::user()->roles_id == 2)
                                            <div class="col">
                                                <button class="btn btn-danger">Masquer</button>
                                            </div>
                                        @endif
                                        <div class="col"><a class="btn btn-info"
                                                            onclick="document.getElementById('formulairecommentaire{{$quack->id}}').style.display = 'block'"
                                            >Commenter
                                            </a>
                                        </div>
                                        @if ($quack->user_id == Auth::user()->id)
                                            <div class="col">
                                                <!--                            si l'utilisateur connecté a posté le quack, il peut le modifier et le supprimer-->
                                                <!--                            <a class="btn btn-info"-->
                                            <!--                               onclick="document.getElementById('formulairemodif{{$quack->id}}').style.display = 'block'"-->
                                                <!--                            >Modifier-->
                                                <!--                            </a>-->
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
                            <form style="display:none;" id="formulairecommentaire{{$quack->id}}"
                                  class="col-12 mx-auto mb-2"
                                  action="{{ route('comments.store') }}"
                                  method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="content">Tapez votre message</label>
                                    <textarea required class="container-fluid" type="text" name="content"
                                              id="content"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4 form-group">
                                        <label for="nom">image (facultatif)</label>
                                        <input type="text" class="form-control" name="image" id="image">
                                    </div>
                                    <input class="form-control" type="hidden" id="quack_id" name="quack_id"
                                           value="{{$quack->id}}">
                                </div>
                                <button class="btn btn-danger"
                                        onclick="document.getElementById('formulairecommentaire{{$quack->id}}').style.display = 'none'">
                                    Annuler
                                </button>
                                <button type="submit" class="btn btn-warning">Valider</button>
                            </form>


                            {{--        <!--                ***************************************modifier le quack******************************-->--}}

                            {{--        <form style="display:none;" id="formulairecommentaire{{$quack->id}}" class="col-12 mx-auto mb-2"--}}
                            {{--              action="{{ route('quacks.update', $quack) }}"--}}
                            {{--              method="POST">--}}
                            {{--            @method("put")--}}
                            {{--            @csrf--}}
                            {{--            <div class="form-group">--}}
                            {{--                <label for="content">Nouveau texte</label>--}}
                            {{--                <input required type="text" class="form-control" name="content"--}}
                            {{--                       value="{{ $quack->content }}" id="content">--}}
                            {{--            </div>--}}
                            {{--            <div class="form-group">--}}
                            {{--                <label for="image">Nouvelle image</label>--}}
                            {{--                <input type="text" class="form-control" name="image" value="{{ $quack->image }}" id="image">--}}
                            {{--            </div>--}}
                            {{--            <div class="form-group">--}}
                            {{--                <label for="tags">Nouveaux tags</label>--}}
                            {{--                <input type="text" class="form-control" name="tags" value="{{ $quack->tags }}" id="tags">--}}
                            {{--                <button type="submit" class="btn btn-primary">Valider</button>--}}
                            {{--            </div>--}}
                            {{--        </form>--}}
                            @foreach($quack->comments as $comment)
                                <div class="container w-75">
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col">{{$comment->user->duckname}}</div>
                                                <div class="col">posté le {{$comment->created_at}}</div>
                                            </div>
                                        </div>
                                        <div class="card-body">{{ $comment->content }}
                                        @if ($quack->user_id === Auth::id() || $comment->user_id === Auth::id())
                                            <!--            si l'utilisateur connecté est l'auteur du quack ou du commentaire, il peut supprimer le commentaire -->
                                                <form action="{{ route('comments.destroy', $comment) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            @endif

                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>


@endsection
