$(document).ready(function() {
    check_picservice_token();
    
    type_id = 1;
    
    updateCalendar(date);
    
    $( "#datepicker" ).datepicker();
    
    
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
    
    $(document).on("click",".calendar_day",function(){
        $('.calendar_day').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        day = $(this).attr("day");
        console.log(year + "." + month + "." + day);
        $('.choosed_date').html(year + "年" + month+1 + "月" + day + "日");
    });

    $('#last_month').on('click', function() {
        date.setMonth(date.getMonth() - 1);
        updateCalendar(date);
    });

    $('#next_month').on('click', function() {
        date.setMonth(date.getMonth() + 1);
        updateCalendar(date);
    });

    $('.save-btn').click(function (){

        var rule_weekdays = [];

        $('.rule-w').each(function (){
            if($(this).hasClass('btn-primary')){
                var w = $(this).attr('id');
                rule_weekdays.push(w);
            }
        });
        
        var worktime = $('#worktime').val();
        var resttime = $('#resttime').val();
        var starttime = $('#datepicker').val();
        
        console.log('type_id : ' + type_id);
        console.log('rule-w : ' + rule_weekdays);
        console.log('worktime : ' + worktime);
        console.log('resttime : ' + resttime);
        console.log('starttime : ' + starttime);
    });
    
    
});

