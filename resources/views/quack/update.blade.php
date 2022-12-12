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
                <form class="col-12 mx-auto" action="{{ route('quacks.update', $quack) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="content">Nouveau texte</label>
                        <input required type="text" class="form-control" name="content" value="{{ $quack->content }}"
                            id="content">
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

                    <div class="form-group">
                        <label for="tags">Nouveaux tags</label>
                        <input type="text" class="form-control" name="tags" value="{{ $quack->tags }}"
                            id="tags">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="{{ $quack->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>

            </div>
            <div class="col-4">
            </div>
        </div>
    </main>
@endsection
