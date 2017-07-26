
$(document).ready(function() {
    //Удаление черной рамки на миниатюре
    $('div.image').click(function() {
        $bord = $('div.image').children(".bord");
        $bord.css("border"," 0px");
    });
    //Очищаем div справа и заполняем данными
    $( 'div.image' ).click(function() {
        $('.cont').empty();
        $(this).clone().appendTo('.cont');
        $id=$(this).children(".id").text();
        $public_link = $(this).children(".public_link").text();
        $uploaded = $(this).children(".uploaded").text();
        $token = $(this).children(".token").text();
        $bord = $(this).children(".bord");
        $bord.css("border"," 1px solid black");
        $a='Uploaded : '+ $uploaded + '<br><br>';
        $('.cont').append($a);
        $('.cont').append('<strong>Public URL : </strong>');
        if($public_link){
            $a='<a href="'+$public_link+'">'+$public_link+'</a><br><br>';
        }else $a='<strong>No</strong><br><br>';
        $('.cont').append($a);
        $a='<a class="btn btn-primary " href="/download/'+$id+'">Download</a>';
        $('.cont').append($a);
        $a='<a class="btn btn-default " href="/share/'+$id+'">Share</a>';
        $('.cont').append($a);
        $a='<a class="btn btn-danger " href="/delete/'+$id+'">Delete</a> <br><br>';
        $('.cont').append($a);
        $a = '<form class="form-inline" action = "/rename/'+$id+'"  method = "POST" accept-charset="UTF-8" enctype="multipart/form-data">'+
            '<input name="_token" type="hidden" value="'+ $token + '">  Rename:<br> <div class="form-group">  <input type="text" class="form-control" name="firstname"><br> ' +
            ' </div><input type="submit" class="btn btn-default " value="Submit">  </div> </form>';
        $('.cont').append($a);
    });

});

