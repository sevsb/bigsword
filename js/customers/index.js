$(document).ready(function() {
    check_picservice_token();
    
    $('.del-btn').click(function () {
        del_id = $(this).attr('id');
        console.log('del_id:' + del_id);
    });
    
    $(".do_del").click(function () {
        $('#del-modal').modal('hide');
        __ajax("customers.delete", {id: del_id}, function (data){
            console.log(data);
            if(data.ret = 'success') {
                $('#customer_' + del_id).remove();
            } else {
                alert('删除失败');
            }
        })
    });
});
