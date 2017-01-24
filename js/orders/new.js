$(document).ready(function() {
    check_picservice_token();

/*     $(document).on("click",".choose_date_li",function(){
        var date_text = $(this).text();
        $(this).parents('.dropdown').find('.dropdown-toggle').html(date_text + "&nbsp<span class='caret'></span>");
        choose_date = $(this).attr("date");
        console.log(choose_date);
    }); */
    
    $(document).on("click",".item_show",function(){
        if ($(this).hasClass('cannot_choose')) {
            return;
        }
        $(this).parents('.order_item_body').find('.item_show').removeClass('selected');
        $(this).addClass("selected");
    }); 
    
});

