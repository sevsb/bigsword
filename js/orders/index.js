$(document).ready(function() {
    //check_picservice_token();
    $('#main_table').DataTable();
    
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
