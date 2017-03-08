$(document).ready(function() {
    
    $('.time_block').mouseover(function (){
        if($(this).hasClass('not_work')) {
            $(this).popover('show');
        }
        
        if($(this).hasClass('has_order')) {
            $(this).popover('show');
        }
    });
    
    $('.time_block').mouseout(function (){
        $(this).popover('hide');
    });

    $('.togo').click(function (){
        url = $(this).attr("url");
        if($(this).hasClass('disabled')) {
            return;
        }
        document.location.href = url;
    });
   
});

