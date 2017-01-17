$(document).ready(function() {
    check_picservice_token();
    type_id = 1;
    
    updateCalendar(date);
    
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
    
    $(document).on("click",".calendar_day",function(){
        $('.calendar_day').removeClass('btn-primary');
        $(this).addClass('btn-primary');
    });


    $('#last_month').on('click', function() {
        date.setMonth(date.getMonth() - 1);
        updateCalendar(date);
    });

    $('#next_month').on('click', function() {
        date.setMonth(date.getMonth() + 1);
        updateCalendar(date);
    });


});

