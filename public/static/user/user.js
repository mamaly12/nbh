users = document.getElementById('users');
if(users)
{
    $(".btn.btn-danger.delete-user").on('click', function(event){
        if(confirm('Are you sure?'))
        {
            const id = event.target.getAttribute('data-id');
            $.ajax({
                url: '/user/delete',
                type: "DELETE",
                data: { "id": id,},
                dataType: "json",
                success : function(data) {
                    if ( data.result ) {
                        window.location='/user/list';
                    }
                }
            });
        }
    });
}