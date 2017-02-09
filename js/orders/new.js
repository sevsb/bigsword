$(document).ready(function() {
    //check_picservice_token();

    $(document).on("click",".item_show",function(){
        if ($(this).hasClass('cannot_choose')) {
            return;
        }
        $(this).parents('.order_item_body').find('.item_show').removeClass('selected');
        $(this).addClass("selected"); 
    });
    
    $(document).on("click", ".service_item_div", function (){
        
    });
    
    $('.service_item_div').find('.item_show').click( function() {
        item_id = $(this).find('.item_id').html();
        item_title = $(this).find('.item_title').html();
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
        console.log(ability_group); //筛选出会此技能的组。
        
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
        
        $(".result_item").find(".result_intro").html('选中的项目是：');
        $('.result_item').find('.result_show').html(item_title);
    });
    
    
    $('.servers_div').find('.item_show').click( function() {
        var staff_id = $(this).attr("id");
        var staff_name = $(this).find(".item_title").html();
        console.log(staff_id);
        var staff_skills = null;
        for (id in staff_services) {
            var skills = staff_services[id].service_id;
            var stf_id = staff_services[id].staff_id;
            skills = skills.split(",");
            if(staff_id == stf_id) {
                staff_skills = skills;
            }
        }
        console.log(staff_skills);  //筛选出此人会的技能
        
        $('.service_item_div').find('.item_show').each(function(){
            var item_id = $(this).find('.item_id').html();
            $(this).addClass('disability');
            if (staff_skills == null) {
                return;
            }
            sk_length = staff_skills.length;
            for (var i = 0; i < sk_length; i++) {
                if (staff_skills[i] == item_id){
                    $(this).removeClass('disability');
                }
            }
        });
        
        $(".result_server").find(".result_intro").html('选中的技师是：');
        $('.result_server').find('.result_show').html(staff_name);
        
        
    });
});

