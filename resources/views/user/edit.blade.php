@extends ('layout.app')

@section('title')
    Mon compte
@endsection

@section('content')
    <main class="container">
        <h3 class="pb-3">Une petite modif ? C'est par ici ! </h3>
        <div class="row">

            <form class="col-4 mx-auto" action="{{ route('user.account.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="prenom">Nouveau prénom</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="prenom"
                        value="{{ $user->prenom }}" id="prenom">
                </div>

                <div class="form-group">
                    <label for="nom">Nouveau nom</label>
                    <input required type="text" class="form-control" name="nom" value="{{ $user->nom }}" id="nom">
                </div>

                <div class="form-group">
                    <label for="image">Nouvelle image (upload ci-dessous)</label>
                    @if (Session::get('image'))
                        <input type="text" class="form-control" name="image" id="image"
                            value="{{ Session::get('image') }}">
                    @else
                        <input type="text" class="form-control" name="image" id="image"
                            placeholder="upload d'images ci-dessous">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="{{ route('image.upload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <p class="mt-3">Uploader une image</p>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <h3 class="pb-3 mt-5">Et pour le mot de passe (ultra secret), c'est là ! </h3>
        <div class="row">
            <form class="col-4 mx-auto" action="{{ route('user.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="label">Mot de passe actuel</label>
                    <div class="control">
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    @if ($errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="label">Nouveau mot de passe</label>
                    <div class="control">
                        <input class="form-control" type="password" name="newPassword" required>
                    </div>
                    @if ($errors->has('newPassword'))
                        <p class="help is-danger">{{ $errors->first('newPassword') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="label">Confirmez le mot de passe</label>
                    <div class="control">
                        <input class="form-control" type="password" name="newPassword_confirmation" required>
                    </div>
                    @if ($errors->has('newPassword_confirmation'))
                        <p class="help is-danger">{{ $errors->first('newPassword_confirmation') }}</p>
                    @endif
                    @if ($errors->has('password_error'))
                        <p class="help is-danger">{{ $errors->first('password_error') }}</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
    </main>
@endsection
