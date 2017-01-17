var date = new Date();
var chooseDate = new Array();
var chooseDays = new Array();

function clickDay(element) {
    if($(element).attr('class') == 'day_unchoose') {
        $(element).attr('class', 'day_choose');
    } else {
        $(element).attr('class', 'day_unchoose');
    }
}

function updateCalendar(date) {

    var year = date.getFullYear();
    var month = date.getMonth();
    $('#year').html(year);
    $('#month').html(month + 1);
    drawCalendarBody(year, month);

}

function drawCalendarBody(year, month) {

    var startDay = new Date(year, month, 1).getDay();
    var endDay = new Date(year, month + 1, 0).getDay();
    var mouthDays = new Date(year, month + 1, 0).getDate();
    var countCol = 0;
    var html = '';
    console.log(startDay);
    console.log(endDay);
    console.log(mouthDays);
    html += '<tr>';
    for (var i = 0; i < startDay; i++) {
        html += '<td></td>';
        countCol++;
    }

    for (var dayNumber = 1; dayNumber <= mouthDays; dayNumber++) {
        html += '<td class="calendar_day" day="' + dayNumber + '">';
        html += '<div class="">' + dayNumber + '</div>';
        html += '</td>';
        countCol++;
        if (countCol == 7) {
            countCol = 0;
            html += '</tr><tr>';
        }
    }

    for (var i = endDay; i < 6; i++) {
        html += '<td></td>';
        countCol++;
    }
    html += '</tr>';
    
    $('#calendar_body').html(html);

}