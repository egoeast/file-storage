@extends('layouts.app')
@section('content')
    @include('partials.flash')
    {!! Form::open(array('url'=>'storage/upload','method'=>'POST', 'files'=>true)) !!}
    <div class="control-group">
        <div class="controls">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-7">
                        <h3>@lang('storage.upload_files')</h3>
                    </div>
                    <div class="col-md-5">
                        <h3>@lang('storage.used_space')</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <label class="input-group-btn">
                            <span class="btn btn-primary">
                                @lang('storage.browse')&hellip; <input name ='uploadFile[]' type="file" style="display: none;" multiple>
                            </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::submit(trans('storage.upload'), array('class'=>'btn btn-primary btn-block')) !!}
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
    <h3>@lang('storage.new_dir')</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::text('directory_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::submit(trans('storage.create'), ['class' => 'btn btn-primary btn-block form-control']) !!}
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
                {!! Form::submit(trans('storage.search'), ['class' => 'btn btn-primary btn-block form-control']) !!}
            </div>
        </div>
        {!! Form::close() !!}

        <hr>
    </div>
    <hr>
    @include('partials.files-list')
    <hr>
    <div class="col-md-6 col-md-offset-5">
        {{ $files->links() }}
    </div>
    <br>
@stop
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>


    $(document).ready(function() {
        //Удаление черной рамки на миниатюре
        $('div.image').click(function() {

        });
        //Очищаем div справа и заполняем данными
        $( 'div.image' ).click(function() {
            $('.cont').empty();
            $(this).clone().appendTo('.cont');
            var id=$(this).children(".id").text();



           // $bord = $('div.image').children(".bord");
          //  $bord.css("border"," 2px solid black");

            var url = "/file";
            $.get(url + '/' + id, function (data) {
                //success data

                console.log(data);



                //alert(data.original_name);
                $('#single-file-img').attr("src", data.thumb_path);
                $('#single-file-name').text(data.original_name);
                $('#single-file-type').text(data.f_type);
                $('#single-file-size').text(data.size);
                $('#single-file-created').text(data.created_at);

                if(data.public_id){
                    $('#single-file-public').attr("href", "/public_link/"+data.public_id );
                    $('#single-file-public').text("/public_link/"+data.public_id);
                }else $('#single-file-public').text("");


                $('#download').attr("href", "/download/"+id);
                $('#share').attr("href", "/share/"+id);
                $('#delete').attr("href", "/delete/"+id);
            })









        });

    });



</script>