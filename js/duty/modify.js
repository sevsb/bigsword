$(document).ready(function() {
    check_picservice_token();
    type_id = 1;
    
    $( "#datepicker" ).datepicker();
    $( ".overtime" ).datepicker();
    $( ".vacation" ).datepicker();
    
    
    $('.duty_type').click(function (){
        type_id = $(this).attr('id');
        $(this).addClass('btn-primary');
        $(this).siblings('.duty_type').removeClass('btn-primary');
        $('.duty_rule_div').each(function (){
            var id = $(this).attr('id');
            if (id == type_id) {
                $(this).removeClass("hide");
            }else {
                $(this).addClass("hide");
            }
        });
        console.log('type_id:' + type_id);
    });
    
    $(".rule-w").click(function (){
        $(this).toggleClass("btn-primary");
    });
    
    $(document).on("click",".sel_item",function(){
        var item_text = $(this).text();
        $(this).parents('.dropdown').find('.dropdown-toggle').html(item_text + "&nbsp<span class='caret'></span>");
    });
    
    $(document).on("click",".del_elf",function(){
        $(this).parents('.elf').remove();
    });
    
    $('.new_vacation_btn').click(function (){
        add_item = '';
        add_item += "<div class='vacation_elf elf'>";
        add_item += "    <input class='vacation' placeholder='日期'></input>";
        add_item += "    <div class='dropdown' style='display:inline-block;'>";
        add_item += "      <button class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown'>";
        add_item += "        请选择类型";
        add_item += "        <span class='caret'></span>";
        add_item += "      </button>";
        add_item += "      <ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu2'>";
        add_item += "       <li class='sel_item' role='presentation'><a role='menuitem' tabindex='-1' >病假</a></li>";
        add_item += "       <li class='sel_item'  role='presentation'><a role='menuitem' tabindex='-1' >年假</a></li>";
        add_item += "       <li class='sel_item'  role='presentation'><a role='menuitem' tabindex='-1' >事假</a></li>";
        add_item += "        <li class='sel_item'  role='presentation'><a role='menuitem' tabindex='-1' >存休</a></li>";
        add_item += "      </ul>";
        add_item += "     </div>";
        add_item += "    <input class='' placeholder='备注'></input>";
        add_item += "    <div class='btn btn-danger del_elf'>删除</div>";
        add_item += " </div>";
        $('.vacation_elf_list').append(add_item);
        $('.vacation').each(function (){
            $(this).datepicker();
        });
    });
    
    $('.new_overtime_btn').click(function (){
        add_item = '';
        add_item += "<div class='overtime_elf elf'>";
        add_item += "    <input class='overtime' placeholder='日期'></input>";
        add_item += "    <div class='dropdown' style='display:inline-block;'>";
        add_item += "      <button class='btn btn-default dropdown-toggle' type='button' id='dropdownMenu1' data-toggle='dropdown'>";
        add_item += "        请选择类型";
        add_item += "        <span class='caret'></span>";
        add_item += "      </button>";
        add_item += "      <ul class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu1'>";
        add_item += "       <li class='sel_item' role='presentation'><a role='menuitem' tabindex='-1' >加班</a></li>";
        add_item += "      </ul>";
        add_item += "     </div>";
        add_item += "    <input class='' placeholder='备注'></input>";
        add_item += "    <div class='btn btn-danger del_elf'>删除</div>";
        add_item += " </div>";
        $('.overtime_elf_list').append(add_item);
        $('.overtime').each(function (){
            $(this).datepicker();
        });
    });

});

