<div class="container" >
    <div class="col-md-8" >
        <div class="row" >

            @for($i=0; $i<$files->count(); $i++ )
                <div class="col-md-3" id="{{$files[$i]->id}}" >

                    @if($files[$i]->f_type=='folder')
                        <div >
                            <a href="/storage/{{ $files[$i]->id }}"><img class="img-thumbnail" src="{{ $files[$i]->thumb_path }}" width="350" height="350"></a>
                            <p style="word-wrap: break-word">{{ $files[$i]->name }} </p>
                    @else
                            <div class="image">
                                <div class="bord"><img class="img-thumbnail" src="{{ $files[$i]->thumb_path }}" width="350" height="350" ></div>
                                <p class="id" hidden="true">{{ $files[$i]->id }}</p>
                                @if($files[$i]->public_id)
                                    <p class="public_link" hidden="true">{{ url('/public_link/')}}/{{$files[$i]->public_id }}<p>
                                @else <p> </p>
                                @endif
                                <p class="uploaded" hidden="true" >{{ $files[$i]->created_at }}</p>
                                <p class="token" hidden="true">{{ Session::get('_token') }}</p>
                                <p >{{ $files[$i]->original_name }} </p>
                                <p>@lang('storage.size') {{ $files[$i]->size }} Kb</p>
                    @endif
                            </div>
                        </div>
                     @if(!(($i+1)%4))
                </div>
                <br>
                <div class="row">
                    @endif

                @endfor
                </div>
        </div>
        <div class="col-md-4">
            @include('partials.single-file')
        </div>
    </div>
</div>

@include('partials.modal')