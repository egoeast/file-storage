@extends('layouts.app')
@section('content')

    <div class="make-switch">
        <input type="checkbox" checked>
    </div>


    <link href="/build/css/bootstrap-switch.css" rel="stylesheet">
    <script src="/build/js/bootstrap-switch.js"></script>
    <input type="checkbox" name="my-checkbox" checked>
    <script>
    $("[name='my-checkbox']").bootstrapSwitch();
    </script>

    <div class="checkbox">
        <label>
            <input type="checkbox" data-toggle="toggle">
            Option one is enabled
        </label>
    </div>
    <div class="checkbox disabled">
        <label>
            <input type="checkbox" disabled data-toggle="toggle">
            Option two is disabled
        </label>
    </div>
    {!! Form::model($user, ['method'=>'PATCH','url'=>'/users/'.$user->id]) !!}
    <div class="form-group">
        {!! Form::label('name', trans('users.name')) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', trans('users.email')) !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
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

    <li class="list-group-item">
        Bootstrap Switch Info
        <div class="material-switch ">
            <input name="is_admin" type="checkbox" value="1" id="is_admin"/>
            <label for="someSwitchOptionInfo" class="label-info"></label>
        </div>
    </li>

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
        {!! Form::label('created_at', trans('users.created')) !!}
        {!! Form::input('date','created_at', date('Y-m-d'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit(trans('users.edit'), ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
    @include('errors.list')


@stop

