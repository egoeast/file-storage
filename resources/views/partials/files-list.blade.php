<div class="container" >
    <div class="col-md-8" >
        <div class="row" >
            <!-- {{ $i = 0 }} -->
            @foreach($files as $file)
                <div class="col-md-3" >

                    @if($file->f_type=='folder')
                        <div >
                            <a href="/storage/{{ $file->id }}"><img class="img-thumbnail" src="{{ $file->thumb_path }}" width="350" height="350"></a>
                            <p style="word-wrap: break-word">{{ $file->name }} </p>
                    @else
                            <div class="image">
                                <div class="bord"><img class="img-thumbnail" src="{{ $file->thumb_path }}" width="350" height="350" ></div>
                                <p class="id" hidden="true">{{ $file->id }}</p>
                                @if($file->public_id)
                                    <p class="public_link" hidden="true">{{ url('/public_link/')}}/{{$file->public_id }}<p>
                                @else <p> </p>
                                @endif
                                <p class="uploaded" hidden="true" >{{ $file->created_at }}</p>
                                <p class="token" hidden="true">{{ Session::get('_token') }}</p>
                                <p >{{ $file->original_name }} </p>
                                <p>@lang('storage.size') {{ $file->size }} Kb</p>
                    @endif
                    <!--  {{ $i++ }}-->
                            </div>
                        </div>
                     @if(!($i%4))
                </div>
                <br>
                <div class="row">
                    @endif
            @endforeach
                </div>
        </div>
        <div class="col-md-4 cont"  >

        </div>
    </div>
</div>