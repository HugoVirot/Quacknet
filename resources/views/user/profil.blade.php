@extends ('layout.app')

@section('title')
    profil
@endsection

@section('content')

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="col">profil de : <h1>{{ $user[0]->duckname }}</h1></div>
                <div class="row mb-2">
                    <div class="col">Prénom : {{ $user[0]->prenom }}, nom : {{ $user[0]->nom }}</div>
                </div>
                @foreach ($quacks as $quack)
                    <div class="card mb-1">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route ('user.profil', $quack->user_id) }}">
                                        <strong>{{ $quack->user->duckname }}</strong>
                                    </a>
                                </div>
                                @if ($quack->created_at != $quack->updated_at)
                                    <div class="col"> modifié le {{ $quack->updated_at }}</div>
                                @else
                                    <div class="col"></div>
                                @endif
                                <div class="col"> posté le {{ $quack->created_at }}</div>
                            </div>
                        </div>
                        <div class="card-img mt-3">
                        <!--                        <img src="{{url('/public/images/-->
                    <?php //echo $quack->image; ?><!--')}}" alt="canard">-->
                            <img class="w-25" src="/images/canard.jpg" alt="canard">
                        </div>
                        <div class="card-body">
                            <div>{{ $quack->content }}</div>
                            <div class="row mt-2">
                                <div class="col">{{ $quack->tags }}</div>
                                <div class="col text-right">
                                    <!--                            <a class="btn btn-primary"-->
                                <!--                               href="{{ route('quacks.destroy', $quack->id) }}">Commenter</a>-->
                                    @if ($quack->user_id == Auth::user()->id)
                                        <form action="{{ route('quacks.destroy', $quack) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </main>

@endsection
