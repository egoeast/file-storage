@extends('layouts.app')
@section('content')


    {!! Form::model($user, ['method'=>'PATCH','url'=>'/users/'.$user->id]) !!}
    <div class="form-group">
        {!! Form::label('name','Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email','Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('max_disk_space','Max disk space') !!}
        {!! Form::text('max_disk_space', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::hidden('is_admin', 0) !!}
        {!! Form::label('is_admin','Is admin') !!}
        {!! Form::checkbox('is_admin', 1) !!}
    </div>

    <div class="form-group">
        {!! Form::hidden('is_blocked', 0) !!}
        {!! Form::label('is_blocked','Is blocked') !!}
        {!! Form::checkbox('is_blocked', 1) !!}
    </div>

    <div class="form-group">
        {!! Form::label('created_at','Date of registration') !!}
        {!! Form::input('date','created_at', date('Y-m-d'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Edit', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
    @include('errors.list')
@stop