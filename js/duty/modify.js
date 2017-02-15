$(document).ready(function() {
// ------------js init ---------------------------
    staff_id = $('.save-btn').attr("id");
    type_id = 1;
    sel_item_btn = 0;
    timestamp = '';
    //check_picservice_token();
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
        var item_text = $(this).html();
        console.log(item_text);
        $(this).parents('.dropdown').find('.dropdown-toggle').html(item_text + "");
        sel_item_btn = $(this).attr("id");
    });
    
    $(document).on("click",".calendar_day",function(){
        day = $(this).attr("day");
        timestamp = $(this).attr("timestamp");
        var newDate = new Date();
        newDate.setTime(timestamp * 1000);
        var this_time = newDate.toLocaleDateString();
        
        console.log(timestamp);
        console.log(this_time);
        type_text = '请选择类型';
        content = '';
        sel_item_btn = 0;
        
        $('.calendar_day').removeClass('btn-choosed');
        $(this).addClass('btn-choosed');
        $('.choosed_date').html(year + "年" + month+1 + "月" + day + "日");
        $('.choosed_date').html(this_time);
        
        if (vacations[timestamp] != null) {
            var this_vacation = vacations[timestamp];
            var content = this_vacation.content
            var type = this_vacation.type
            sel_item_btn = type;
            type_text = event_settings[type].title;
            

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
        if (timestamp == '') {
            alert("请选择日期");
            return;
        }
        __ajax('duty.make_event',{staff_id: staff_id, timestamp: timestamp ,type: sel_item_btn ,content: content},true);
    });
    
    $('.cancel_event_btn').click(function (){
        if (timestamp == '') {
            return;
        }
        __ajax('duty.cancel_event',{staff_id: staff_id, timestamp: timestamp},true);
    });
    
});

function getDate(tm){
    var tt=new Date(parseInt(tm) * 1000).toLocaleString() 
    return tt; 
} 