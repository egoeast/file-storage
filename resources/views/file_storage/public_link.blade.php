@extends('layouts.app')
@section('content')

    <h2>@lang('storage.file'){{$file->original_name}}</h2>
    <br>
    <div class="col-md-10 col-md-offset-1">
        <img src="{{ $file->thumb_path }}"  width="400" height="400">
        <p>@lang('storage.file_type'){{ $file->f_type}}</p>
        <p>@lang('storage.created_at'){{ $file->created_at }}</p>
        <p>@lang('storage.size'){{ $file->size }} Kb</p>
        <a class="btn btn-primary" href="/public_download/{{$file->id}}">@lang('storage.download')</a>
    </div>
@endsection