@extends('layout.app')

@section('title')
Accueil
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card pb-3">
                <div class="card-header">liste des quacks</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="/home" method="POST">
                        <label for="message">Tapez votre message</label>
                        <textarea required type="text" name="message" id="message"></textarea>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

