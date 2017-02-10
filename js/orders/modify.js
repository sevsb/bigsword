$(document).ready(function() {
// ------------js init ---------------------------
    staff_id = $('.save-btn').attr("id");
    type_id = 1;
    sel_item_btn = 0;
    selected_day = '';
    check_picservice_token();
    $('.duty_type').each(function () {
        if($(this).hasClass("btn-primary")) {
            type_id = $(this).attr("id");
        }
    });
    updateCalendar(date);
    $( "#datepicker" ).datepicker();
    $( "#datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
    starttime = $( "#datepicker" ).attr("starttime");
    $('#datepicker').val(starttime); 

// ------------js 效果 ---------------------------

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
        //console.log('now_choosed_type_id:' + type_id);
    });
    
    $(".rule-w").click(function (){
        $(this).toggleClass("btn-primary");
    });
    
    $(document).on("click",".sel_item",function(){
        var item_text = $(this).text();
        $(this).parents('.dropdown').find('.dropdown-toggle').html(item_text + "&nbsp<span class='caret'></span>");
        sel_item_btn = $(this).attr("id");
    });
    
    $(document).on("click",".calendar_day",function(){
        day = $(this).attr("day");
        selected_day = year + "-" + month + "-" + day;
        type_text = '请选择类型';
        content = '';
        sel_item_btn = 0;
        
        $('.calendar_day').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $('.choosed_date').html(year + "年" + month+1 + "月" + day + "日");
        
        if (vacations[selected_day] != null) {
            var this_vacation = vacations[selected_day];
            var content = this_vacation.content
            var type = this_vacation.type
            sel_item_btn = type;
            if(type == 1) {
                type_text = '正常休息';
            }
            if(type == 2) {
                type_text = '病假';
            }
            if(type == 3) {
                type_text = '年假';
            }
            if(type == 4) {
                type_text = '事假';
            }
            if(type == -1) {
                type_text = '存休';
            }
            if(type == -2) {
                type_text = '加班';
            }

        }
        $('.sel_item_btn').html(type_text + "&nbsp<span class='caret'></span>");
        $('.event_content').text(content);
    });

    $('#last_month').on('click', function() {
        date.setMonth(date.getMonth() - 1);
        updateCalendar(date);
    });

    $('#next_month').on('click', function() {
        date.setMonth(date.getMonth() + 1);
        updateCalendar(date);
    });

    
// ------------js 提交 ---------------------------

    $('.save-btn').click(function (){
        var rule_weekdays = [];
        $('.rule-w').each(function (){
            if($(this).hasClass('btn-primary')){
                var w = $(this).attr('id');
                rule_weekdays.push(w);
            }
        });
        var staff_id = $(this).attr("id");
        var worktime = $('#worktime').val();
        var resttime = $('#resttime').val();
        var starttime = $('#datepicker').val();
        var rule_workrest = new Object();
        rule_workrest.worktime = worktime;
        rule_workrest.resttime = resttime;
        rule_workrest.starttime = starttime;
        type_id == 1 ? ruledetail = rule_weekdays : ruledetail = rule_workrest;
        __ajax('duty.setrule',{staff_id: staff_id, type: type_id ,rule: ruledetail},true);
    });
    
    $('.new_event_btn').click(function (){
        var content = $('.event_content').val();
        if (sel_item_btn == 0) {
            alert("请选择类型");
            return;
        }
        if (selected_day == '') {
            alert("请选择日期");
            return;
        }
        __ajax('duty.make_event',{staff_id: staff_id, date: selected_day ,type: sel_item_btn ,content: content},true);
    });
    
    $('.cancel_event_btn').click(function (){
        if (selected_day == '') {
            return;
        }
        __ajax('duty.cancel_event',{staff_id: staff_id, date: selected_day},true);
    });
    
});

