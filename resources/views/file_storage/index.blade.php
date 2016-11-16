@extends('layouts.app')
@section('content')
    @include('partials.flash')
    {!! Form::open(array('url'=>'storage/upload','method'=>'POST', 'files'=>true)) !!}
    <div class="control-group">
        <div class="controls">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-7">
                        <h3>Upload file</h3>
                    </div>
                    <h3>Used space</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Browse&hellip; <input name ='uploadFile[]' type="file" style="display: none;" multiple>
                            </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::submit('Upload', array('class'=>'btn btn-primary btn-block')) !!}
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">

                        <!-- Disk space Bar

                        {{ $capacity = Auth::user()->disk_space/Auth::user()->max_disk_space*100 }}
                        @if( $capacity<=40 )
                        {{ $bar = "progress-bar-success" }}
                        @elseif ( ($capacity<=70)&&($capacity>40) )
                        {{ $bar = "progress-bar-warning" }}
                        @else
                        {{ $bar = "progress-bar-danger" }}
                        @endif
                                -->
                        <div class="row">
                            <div class="progress">
                                <div class="progress-bar {{ $bar }} progress-bar-striped active" role="progressbar" aria-valuenow="{{ $capacity  }}"
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{ $capacity  }}%">
                                    <b style="color: black">{{ Auth::user()->disk_space }}/{{ Auth::user()->max_disk_space }} Mb</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="errors">{!!$errors->first('image')!!}</p>
            @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
            @endif
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(array('url'=>'mkdir','method'=>'POST')) !!}
    <h3>Create Directory</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::text('directory_name', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::submit('Make Dir', ['class' => 'btn btn-primary btn-block form-control']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    @include('errors.list')

    <!-- Folder path -->

    <hr>
    <div class="row">
        <div class="col-md-8">
            <img src="\Thumbnail\folder.png" width="35" height="35" >
            @foreach(\Session::get('folders') as $key=>$val)
                <a style="font-size: 20px;" href="\storage\move\{{ $key }}" ><b>  {{ $val }}</b></a><b> >> </b>
            @endforeach
        </div>

        {!! Form::open(array('url'=>'search','method'=>'GET')) !!}
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::text('search_str', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Search', ['class' => 'btn btn-primary btn-block form-control']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    <hr>
    </div>
    <hr>
    @include('partials.files_list')
    <hr>
        <div class="col-md-6 col-md-offset-5">
        {{ $files->links() }}
        </div>
    <br>
@stop
