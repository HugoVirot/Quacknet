@extends ('layouts.app')

@section('title')
QuackNet - Modifier un quack
@endsection

@section('content')

<main class="container">
    <div class="container text-center">
        @if ($message = Session::get('success'))
        <div class="container">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4 text-center">
            <form class="col-12 mx-auto" action="{{ route('quacks.update', $quack) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="content">Nouveau texte</label>
                    <input required type="text" class="form-control" name="content" value="{{ $quack->content }}" id="content">
                </div>
                <div class="form-group">
                    <label for="image">Nouvelle image</label>
                    @if(Session::get('image'))
                    <input type="text" class="form-control" name="image" id="image" value="{{ Session::get('image') }}">
                    @else
                    <input type="text" class="form-control" name="image" id="image" placeholder="upload d'image ci-dessous">
                    @endif
                </div>
                <div class="form-group">
                    <label for="tags">Nouveaux tags</label>
                    <input type="text" class="form-control" name="tags" value="{{ $quack->tags }}" id="tags">
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="{{ $quack->id }}">
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