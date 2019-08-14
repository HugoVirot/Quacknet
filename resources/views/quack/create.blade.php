@extends ('layout.app')

@section('title')
    Créer un quack
@endsection

@section('content')
<form action="/read" method="POST">
    <label for="message">Tapez votre message</label>
    <textarea required type="text" name="message" id="message"></textarea>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>
@endsection
