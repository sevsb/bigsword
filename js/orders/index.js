$(document).ready(function() {
    //check_picservice_token();
    $('#main_table').DataTable( {
              //跟数组下标一样，第一列从0开始，这里表格初始化时，第四列默认降序
                "order": [[ 1, "desc" ]]
    });


    
    $('.done').click(function (){
        id = $(this).parents('tr').attr('id');
        __ajax("orders.done",{id: id},function() {
            window.location.href='?orders/index';
        });
    });

    $('.cancel').click(function (){
        id = $(this).parents('tr').attr('id');
        __ajax("orders.cancel",{id: id},function() {
            window.location.href='?orders/index';
        });
    });
    
    
    
  
});
