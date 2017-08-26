$(document).ready(function() {

    $("#delete").click(function() {

        if (confirm("Вы уверены, что хотите удалить этот файл?"))
        {
            var id = $(this).attr("data-file-id");
            var url = "/delete/" + id;

            $.ajax( {
                url: url,
                type: 'get',
                success: function(result) {
                    $("#"+id).remove();
                    $(".single-file-container").css("display", "none");
                },
                error: function(result) {
                    alert("Error");
                }
            });
        }
    });

    $("#share").click(function()
    {

        var id = $(this).attr("data-file-id");
        var url = "/share/" + id;

        $.get(url, function (data) {
            $('#single-file-public').attr("href", "/public_link/"+data);
            $('#single-file-public').text("/public_link/"+data);
        });
    });

    //Удаление черной рамки на миниатюре
    $('div.image').click(function() {

    });
    //Очищаем div справа и заполняем данными
    $( 'div.image' ).click(function() {
        $('.cont').empty();
        $(this).clone().appendTo('.cont');
        var id=$(this).children(".id").text();
        alert(id);
        // $bord = $('div.image').children(".bord");
        //  $bord.css("border"," 2px solid black");

        var url = "/file";
        $.get(url + '/' + id, function (data) {
            //success data

            $(".single-file-container").css("display", "block");
            $(".single-file-container").attr("data-file-id", id);
            $("#single-file-img").attr("src", data.thumb_path);
            $("#single-file-name").text(data.original_name);
            $("#single-file-type").text(data.f_type);
            $("#single-file-size").text(data.size);
            $("#single-file-created").text(data.created_at);

            if(data.public_id){
                $('#single-file-public').attr("href", "/public_link/"+data.public_id );
                $('#single-file-public').text("/public_link/"+data.public_id);
            }else $('#single-file-public').text("");

            $('#download').attr("href", "/download/"+id);
            $('#share').attr("data-file-id", id);
            $('#delete').attr("data-file-id", id);
        })
    });

});

$(document).ready(function() {

    var modalElement = '#modal-katalog';
    var modalHeight = $(modalElement).height();

    $('a#rename').click( function(event){
        event.preventDefault();
        $("#new-name").val($("#single-file-name").text());

        var elementOffset = $(this).offset();
        var elementOffsetWindow = elementOffset.top-$(window).scrollTop();


        $(modalElement)
            .css('display', 'block')
            .animate({opacity: 1}, 200);

        if(elementOffsetWindow+modalHeight>$(window).height()) {
            $(modalElement).offset({ top: elementOffset.top-modalHeight-50, left: elementOffset.left-130 });
        } else {
            $(modalElement).offset({ top: elementOffset.top+30, left: elementOffset.left-130 });
        }
    });

    $('#modal_close').click( function(){
        modalClose();
    });
});


function modalClose() {
    var modalElement = '#modal-katalog';
    $(modalElement)
        .animate({opacity: 0, top: '45%'}, 200,
            function(){
                $(this).css('display', 'none');
            }
        );
}

function call() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var modalElement = '#modal-katalog';
    var msg = {
        firstname: $('#new-name').val(),
    }
    $.ajax({
        type: 'POST',
        url: '/rename/' +  $(".single-file-container").attr("data-file-id"),
        data: msg,
        success: function(data) {
            $("#single-file-name").text(msg.firstname);
            modalClose();
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });

}



//Плагин загрузки файлов
$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });

});
