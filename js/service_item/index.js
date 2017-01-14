$(document).ready(function() {
    check_picservice_token();
    
    $('.del-btn').click(function (){
        del_id = $(this).attr('id');
        console.log('del_id:' + del_id);
    });
    
    $(".do_del").click(function (){
        $('#del-modal').modal('hide');
        __ajax("service_item.delete",{id:del_id},function (data){
            console.log(data);
            if (data.ret = 'success') {
                $('#item_' + del_id).remove();
            }else {
                alert('删除失败');
            }
        })
    });
});
