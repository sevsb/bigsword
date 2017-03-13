$(document).ready(function() {
    var clock = $('#page-wrapper').attr('clock');
    var scale = 3;
    var width = 18;
    
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
    
    $('.zoom_out').click(function (){
        if (scale < 3) {
            width += 6;
            scale++;
            zoom(width);
            console.log(width);
            console.log(scale);
            time_scale_change(scale, width);
        }
        
    });
    
    $('.zoom_in').click(function (){
        if (scale > 1) {
            width -= 6;
            scale--;
            zoom(width);
            console.log(width);
            console.log(scale);
            time_scale_change(scale, width);
        }
    });
   

});

function zoom(width) {
    var clock = $('#page-wrapper').attr('clock');
    $('.time_block').each(function (){
        $(this).css("width",width + "px");
    });
    $('.staff_status_body').each(function (){
        min_width = clock * 6 * width;
        $(this).css('min-width', min_width + 'px');
    });
}

function time_scale_change(scale, width) {
    var scale = parseInt(scale);
    var start_clock = parseInt($('#page-wrapper').attr('start_clock'));
    var clock =  parseInt($('#page-wrapper').attr('clock'));
    min_width = clock * 6 * width;
    output = '';
    j = 0;
    for(i = 0; i < clock * 6; i++) {
        echo ='';
        if(scale == 3) {
            if(i % 6 == 0){
                echo = start_clock + j + ":00" ;
                j++;
            }
        }else {
            if(i % 12 == 0){
                echo = start_clock + j + ":00" ;
                j += 2;
            }
        }
        output += "<div class='time_block_info'>" + echo + "</div>";
    }
    $('#time_scale').html(output);
    $("#time_sacle").css('min-width', min_width + 'px');
    $('.time_block_info').each(function (){
        $(this).css("width", width + 'px');
        $(this).css("margin-left",'0px');
    });


    
}
