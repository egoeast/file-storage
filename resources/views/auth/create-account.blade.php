@extends('layouts.app')
@section('content')


    {!! Form::open(['url'=>'/users']) !!}
    <div class="form-group">
        {!! Form::label('name', trans('users.name')) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', trans('users.email')) !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', trans('users.password')) !!}
        {!! Form::text('password', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('max_disk_space', trans('users.max_space')) !!}
        {!! Form::text('max_disk_space', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::hidden('is_admin', 0) !!}
        {!! Form::label('is_admin', trans('users.is_admin')) !!}
        {!! Form::checkbox('is_admin', 1) !!}
    </div>

    <div class="form-group">
        {!! Form::hidden('is_blocked', 0) !!}
        {!! Form::label('is_blocked', trans('users.is_blocked')) !!}
        {!! Form::checkbox('is_blocked', 1) !!}

    </div>

    <div class="form-group">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::label('is_active', trans('users.is_active')) !!}
        {!! Form::checkbox('is_active', 1) !!}

    </div>


    <div class="form-group">
        {!! Form::submit(trans('users.create'), ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
    @include('errors.list')


@stop

