<div id="modal-katalog">
    <span id="modal_close">X</span>

    <form class="form-inline" id="rename-form" action = "javascript:void(null);"  method = "PUT" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="call()">
        <input name="_token" type="hidden" value="'+ $token + '">  Rename:<br> <div class="form-group">

            <input type="text" class="form-control" id="new-name" name="firstname"><br>
            <input type="submit" class="btn btn-default " value="Submit">  </div> </form>
    <div class="debug"></div>
</div>
<div id="overlay"></div>

<meta name="_token" content="{!! csrf_token() !!}" />