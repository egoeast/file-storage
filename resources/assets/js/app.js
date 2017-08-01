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

            //console.log(data);

            //alert(data.original_name);
            $(".single-file-container").css("display", "block");
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