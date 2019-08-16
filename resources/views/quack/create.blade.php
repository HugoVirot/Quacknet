@extends ('layout.app')

@section('title')
    Créer un quack
@endsection

@section('content')
<main class="container">
    <div class="container text-center">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4 border border-dark p-3">
            <form class="col-12 mx-auto" action="{{ route('quacks.store') }}" method="POST">
                @csrf
{{--                @method('PUT')--}}
                <div class="form-group">
                    <label for="content">Tapez votre message</label>
                    <textarea required type="text" name="content" id="content"></textarea>
                </div>
                <div class="form-group">
                    <label for="nom">choisissez une image</label>
                    <input type="text" class="form-control" name="image" id="image">
                </div>
                <div class="form-group">
                    <label class="label">ajoutez des tags</label>
                    <div class="control">
                        <input class="form-control" type="text" name="tags">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
        <div class="col-4">
        </div>
    </div>
</main>
@endsection

{{--                    @if($errors->has('password_confirmation'))--}}
{{--                        <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>--}}
{{--                    @endif--}}
