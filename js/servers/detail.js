$(document).ready(function() {
    check_picservice_token();
    
    content = $('.area_content').val();
    $('#content').html(content);
    
    $('.del-btn').click(function (){
        del_id = $(this).attr('id');
        console.log('del_id:' + del_id);
    });
    
    $(".do_del").click(function (){
        $('#del-modal').modal('hide');
        __ajax("servers.delete",{id:del_id},function (data){
            console.log(data);
            if (data.ret = 'success') {
                window.location.href = '?servers/index';
            }else {
                alert('删除失败');
            }
        })
    });
});

