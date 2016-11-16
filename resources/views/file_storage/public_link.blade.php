@extends('layouts.app')
@section('content')

    <h2>File:{{$file->original_name}}</h2>
    <br>
    <div class="col-md-10 col-md-offset-1">
        <img src="{{ $file->thumb_path }}"  width="400" height="400">
        <p>Type : {{ $file->f_type}}</p>
        <p>Created : {{ $file->created_at }}</p>
        <p>Size : {{ $file->size }} Kb</p>
        <a class="btn btn-primary" href="/public_download/{{$file->id}}">Download</a>
    </div>
@endsection