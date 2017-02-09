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
        
        var ability_group = [];
        for (staff_id in staff_services) {
            var skills = staff_services[staff_id].service_id;
            var stf_id = staff_services[staff_id].staff_id;
            skills = skills.split(",");
            sk_length = skills.length;
            for (var i = 0 ; i < sk_length ; i++) {
                if(skills[i] == item_id){
                    ability_group.push(stf_id);
                }
            }
        }
        console.log(ability_group);
        $('.servers_div').find('.item_show').each(function(){
            var staff_id = $(this).attr('id');
            ab_length = ability_group.length;
            for (var i = 0; i < ab_length; i++) {
                if (ability_group[i] == staff_id){
                    $(this).removeClass('disability');
                }else {
                    $(this).addClass('disability');
                }
            }
        });
    });
    
    
});

