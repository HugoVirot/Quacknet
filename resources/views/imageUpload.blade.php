@extends('layout.app')

@section('title')
QuackNet - Uploader une image
@endsection

@section('content')
<div class="container">
    <div class="panel panel-primary">

        <div class="panel-body">


            <form action="{{ route('image.upload.post') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection