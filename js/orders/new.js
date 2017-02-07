$(document).ready(function() {
    //check_picservice_token();

    $(document).on("click",".item_show",function(){
        if ($(this).hasClass('cannot_choose')) {
            return;
        }
        if ($(this).hasClass("selected")) {
            $(this).parents('.order_item_body').find('.item_show').removeClass('selected');
            return;
        }
        $(this).parents('.order_item_body').find('.item_show').removeClass('selected');
        $(this).addClass("selected"); 
    });
    
    $(document).on("click", ".service_item_div", function (){
        
    });
    
    $('.service_item_div').find('.item_show').click( function() {
        item_id = $(this).find('.item_id').html();
        console.log(item_id);
        
        //console.log(staffs);
        var disability_group = [];
        for (staff_id in staffs) {
            
            var staff = staffs[staff_id];
            var summary = staff.summary;
            console.log(summary);
        }
    });
    
    
});

