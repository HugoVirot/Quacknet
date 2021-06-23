@extends ('layout.app')

@section('title')
QuackNet - Modifier un commentaire
@endsection

@section('content')

<main class="container">

    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4 text-center">
            <form class="col-12 mx-auto" action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="content">Nouveau texte</label>
                    <input required type="text" class="form-control" name="content" value="{{ $comment->content }}" id="content">
                </div>
                <div class="form-group">
                    <label for="tags">Nouveau(x) tag(s)</label>
                    <input type="text" class="form-control" name="tags" value="{{ $comment->tags }}" id="tags">
                </div>
                <div class="form-group">
                    <label for="image">Nouvelle image</label>
                    @if(Session::get('image'))
                    <input type="text" class="form-control" name="image" id="image" value="{{ Session::get('image') }}">
                    @else
                    <input type="text" class="form-control" name="image" placeholder="upload d'image ci-dessous" value="{{ $comment->image }}" id="image">
                    @endif
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="{{ $comment->id }}">
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>

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
        <div class="col-4">
        </div>
    </div>
</main>

@endsection