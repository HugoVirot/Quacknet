@extends ('layout.app')

@section('title')
    QuackNet - Modifier un commentaire
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
            <div class="col-4 text-center">
                <form class="col-12 mx-auto" action="{{ route('comments.update', $comment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="content">Nouveau texte</label>
                        <input required type="text" class="form-control" name="content" value="{{ $comment->content }}"
                               id="content">
                    </div>
                    <div class="form-group">
                        <label for="image">Nouvelle image</label>
                        <input type="text" class="form-control" name="image" value="{{ $comment->image }}" id="image">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="{{ $comment->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
            <div class="col-4">
            </div>
        </div>
    </main>

@endsection
