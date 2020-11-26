@extends ('layout.app')

@section('title')
    QuackNet - Créer un quack
@endsection

@section('content')
<main class="container">
            <div class="col-md-10 m-auto">
                <div class="container-fluid">
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
                <div class="row p-5 justify-content-center">
                    <h3>Poster un quack</h3>
                </div>
                <div class="container w-50">
                    <div class=" row border border-dark p-3 mb-2">
                        <form class="col-12 mx-auto mb-2" action="{{ route('quacks.store') }}" method="POST">
                            @csrf
                            {{-- @method('PUT')--}}
                            <div class="form-group">
                                <label for="content">Tapez votre message</label>
                                <textarea required  class="container-fluid" type="text" name="content" id="content"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="nom">choisissez une image</label>
                                    <input type="text" class="form-control" name="image" id="image">
                                </div>
                                <div class="col-6 form-group">
                                    <label class="label">ajoutez des tags</label>
                                    <div class="control">
                                        <input class="form-control" type="text" name="tags">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Quack !</button>
                        </form>
                    </div>
                </div>
            </div>
</main>
@endsection

{{--                    @if($errors->has('password_confirmation'))--}}
{{--                        <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>--}}
{{--                    @endif--}}
