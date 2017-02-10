var date = new Date();
var chooseDate = new Array();
var chooseDays = new Array();

function updateCalendar(date) {

    year = date.getFullYear();
    month = date.getMonth();
    $('#year').html(year);
    $('#month').html(month + 1);
    drawCalendarBody(year, month);

}

function drawCalendarBody(year, month) {

    __ajax("duty.get_duty", {id: staff_id}, function (data) {
        info = data.info;
        vacations = info.vacation;
        vacations = JSON.parse(vacations);
        console.log(vacations);
        var startDay = new Date(year, month, 1).getDay();
        var endDay = new Date(year, month + 1, 0).getDay();
        var mouthDays = new Date(year, month + 1, 0).getDate();
        var countCol = 0;
        var html = '';
        //console.log(startDay);
        //console.log(endDay);
        //console.log(mouthDays);
        html += '<tr>';
        for (var i = 0; i < startDay; i++) {
            html += '<td></td>';
            countCol++;
        }

        for (var dayNumber = 1; dayNumber <= mouthDays; dayNumber++) {
            thisday = year + "-" + (month + 1) + "-" + dayNumber ;
            timestamp = Date.parse(thisday) / 1000;
            html += '<td class="calendar_day" thisday="' + thisday + '" day="' + dayNumber + '" timestamp="' + timestamp + '">';
            html += '<div class="">' + dayNumber + '</div>';
            for (var event_date in vacations) {
                if (event_date == timestamp) {
                    html += '<div class="notice"></div>';
                }
            }
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
    });
    

}