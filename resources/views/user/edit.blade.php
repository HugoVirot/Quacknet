@extends ('layouts.app')

@section('title')
    Mon compte
@endsection

@section('content')
    <main class="container">
        <h3 class="pb-3">Une petite modif ? C'est par ici ! </h3>
        <div class="row">

            <form class="col-4 mx-auto" action="{{ route('user.account.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="pseudo">Nouveau pseudo</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="pseudo"
                        value="{{ $user->pseudo }}" id="pseudo">
                </div>

                <div class="form-group">
                    <label for="image">Nouvelle image</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
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
