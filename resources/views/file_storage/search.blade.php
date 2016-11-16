@extends('layouts.app')
@section('content')
    {!! Form::open(array('url'=>'search','method'=>'GET')) !!}
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    {!! Form::text('search_str', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::submit('Search', ['class' => 'btn btn-primary btn-block form-control']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}

   @include('partials.files_list')
@stop
