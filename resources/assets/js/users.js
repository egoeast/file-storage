$(document).ready(function() {
    $('.delete-user').click(function() {
        if (confirm("Вы уверены, что хотите удалить пользователя?"))
        {
            var id = $(this).attr('data-user-id');
            $.ajax({
                url: '/users/delete/'+id,
                type: 'GET',
                success: function(result) {
                    $("#"+id).remove();
                },
                error: function(result) {
                    alert("Error");
                }
            });
        }
    });
});
