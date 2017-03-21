var STAFF_FIRST = 0;
var SERVICE_ITEM_FIRST = 1;

var switch_flag = SERVICE_ITEM_FIRST;

var service_item_selected = false;
var staff_selected = false;
var time_in_use = false;

var service_item_timeout_id;
var staff_timeout_id;
var timeout_period = 8 * 1000;

var staffs_list = new Array();
var service_items_list = new Array();

var date_selected;

var vacation_list = new Array();

var time_select_list = new Array();

// There is the output parameter
var customer_name = null;
var customer_tel = null;
var staff_id = -1;
var service_item_id = -1;
var service_item_time = 0;
var service_item_start_time = 0;

window.onresize = function() {
    if(switch_flag == SERVICE_ITEM_FIRST) {
        $('#service_item_div').css({left: 0});
        $('#staff_div').css({left: 0});
        $('#service_item_switch_btn').popover('hide');
    } else {
        var div_width = $('#time_div').offset().left / 2;
        $('#service_item_div').css({left: div_width});
        $('#staff_div').css({left: -div_width});
        $('#staff_switch_btn').popover('hide');
    }
}

$(document).ready(function() {
    console.log(timestamps);
    //date_selected = timestamps[0];
    date_selected = get_request('date_selected', timestamps[0]);

    vacation_list[timestamps[0]] = new Array();
    vacation_list[timestamps[1]] = new Array();
    vacation_list[timestamps[2]] = new Array();
    vacation_list[timestamps[3]] = new Array();
    vacation_list[timestamps[4]] = new Array();

    time_select_list[timestamps[0]] = new Array();
    time_select_list[timestamps[1]] = new Array();
    time_select_list[timestamps[2]] = new Array();
    time_select_list[timestamps[3]] = new Array();
    time_select_list[timestamps[4]] = new Array();

    init_data();
    hide_staff_on_vacation();

    $('#service_item_number').text(count_service_item());
    $('#staff_number').text(count_staff());

    $('.choose_date_li').on('click', function() {
        date_selected = $(this).attr('date');
        $('.date_show').text($(this).text());
        hide_staff_on_vacation();
        $('#staff_number').text(count_staff());
        if($('#staffs_list').find('.item_show.active').is('.on_vacation') && switch_flag == STAFF_FIRST) {
            staff_id = -1;
            staff_selected = false;
            $('#staffs_list').find('.item_show.btn-primary').removeClass('btn-primary');
            $('#staffs_list').find('.item_show.active').removeClass('active');
            toggle_staff_result();
            service_item_id = -1;
            service_item_selected = false;
            service_item_time = 0;
            $('#service_items_list').find('.item_show.btn-primary').removeClass('btn-primary');
            $('#service_items_list').find('.item_show.active').removeClass('active');
            $('#service_items_list').find('.item_show.hide').removeClass('hide');
            $('#service_item_number').text(count_service_item());
            toggle_service_item_result();
            toggle_time_select();
        } else if($('#staffs_list').find('.item_show.active').is('.on_vacation') && switch_flag == SERVICE_ITEM_FIRST) {
            staff_id = -1;
            staff_selected = false;
            $('#staffs_list').find('.item_show.btn-primary').removeClass('btn-primary');
            $('#staffs_list').find('.item_show.active').removeClass('active');
            toggle_staff_result();
            toggle_time_select();
        } else {

        }
    });

    $('.switch_btn').on('click', function() {
        change_first();
        if(switch_flag == SERVICE_ITEM_FIRST) {
            staff_id = -1;
            staff_selected = false;
        } else {
            service_item_id = -1;
            service_item_selected = false;
            service_item_time = 0;
        }
        toggle_time_select();
    });

    $('.item_show').on('click', function() {
        $(this).siblings('.item_show').removeClass('btn-primary');
        $(this).siblings('.item_show').removeClass('active');
        $(this).addClass('active');
        $(this).addClass('btn-primary');

        if($(this).parent().attr('id') == 'service_items_list') {
            window.clearTimeout(service_item_timeout_id);
            window.clearTimeout(staff_timeout_id);
            $('#staff_switch_btn').popover('hide');
            service_item_selected = true;
            service_item_id = $(this).attr('id').split('-')[1];

            if(!staff_selected) {
                if(switch_flag == STAFF_FIRST) {
                    change_first();
                }

                service_item_timeout_id = window.setTimeout("$('#service_item_switch_btn').popover('show')", timeout_period);
            }
            if(switch_flag != STAFF_FIRST) {
                staff_id = -1;
                staff_selected = false;
                $('#staffs_list').find('.item_show').removeClass('btn-primary');
                $('#staffs_list').find('.item_show').removeClass('active');
                $('#staffs_list').find('.item_show').addClass('hide');

                var staffs = service_items_list[service_item_id].split(',');
                for(i in staffs) {
                    $('#staff-' + staffs[i]).removeClass('hide');
                }
                $('#staff_number').text(count_staff());
            }

            toggle_service_item_result();

        } else {
            window.clearTimeout(service_item_timeout_id);
            window.clearTimeout(staff_timeout_id);
            $('#service_item_switch_btn').popover('hide');
            staff_selected = true;
            staff_id = $(this).attr('id').split('-')[1];

            if(!service_item_selected) {
                if(switch_flag == SERVICE_ITEM_FIRST) {
                    change_first();
                }

                staff_timeout_id = window.setTimeout("$('#staff_switch_btn').popover('show')", timeout_period);
            }

            if(switch_flag != SERVICE_ITEM_FIRST) {
                service_item_id = -1;
                service_item_selected = false;
                service_item_time = 0;
                $('#service_items_list').find('.item_show').removeClass('btn-primary');
                $('#service_items_list').find('.item_show').removeClass('active');
                $('#service_items_list').find('.item_show').addClass('hide');

                var service_items = staffs_list[staff_id].split(',');
                for(i in service_items) {
                    $('#service_item-' + service_items[i]).removeClass('hide');
                }
                $('#service_item_number').text(count_service_item());
            }

            toggle_staff_result();

        }
        if(typeof($(this).attr('time')) != 'undefined') {
            service_item_time = $(this).attr('time');
        }

        toggle_time_select();
    });

    $('.time_block').mouseout(function() {
        var over_time = $(this).attr('id').split('-');
        var hour = Number(over_time[0]);
        var minute = Number(over_time[1]);
        for(var i = 0; i < service_item_time / 10; i++) {
            $('.can_not_selected').removeClass('can_not_selected');
            $('.can_be_selected').removeClass('can_be_selected');
            minute += 10;
            if(minute >= 60) {
                hour++;
                minute = 0;
            }
        }
        time_in_use = false;
        $(this).tooltip('hide');
    });
    $('.time_block').mouseover(function() {
        var over_time = $(this).attr('id').split('-');
        var hour = Number(over_time[0]);
        var minute = Number(over_time[1]);
        var time_block_array = new Array();
        for(i = 0; i < service_item_time / 10; i++) {
            if($('#'+hour+'-'+minute).length > 0) {
                time_block_array.push('#'+hour+'-'+minute);
                minute += 10;
                if(minute >= 60) {
                    hour++;
                    minute = 0;
                }
            }
        }
        for(i in time_block_array) {
            if($(time_block_array[i]+'.in_use').length > 0) {
                time_in_use = true;
            }
        }
        if(Number(i) + 1 < (service_item_time / 10)) {
            time_in_use = true;
        }
        if(time_in_use) {
            for(i in time_block_array) {
                $(time_block_array[i]).addClass('can_not_selected');
            }
        } else {
            for(i in time_block_array) {
                $(time_block_array[i]).addClass('can_be_selected');
            }
        }
    });
    $('.time_block').on('click', function() {
        if(time_in_use) {
            // TODO: Need to remind the user can not select this time.
        } else {
            $('.selected').removeClass('selected');
            var over_time = $(this).attr('id').split('-');
            var hour = Number(over_time[0]);
            var minute = Number(over_time[1]);
            for(var i = 0; i < service_item_time / 10; i++) {
                $('#'+hour+'-'+minute).addClass('selected');
                minute += 10;
                if(minute >= 60) {
                    hour++;
                    minute = 0;
                }
            }
            service_item_start_time = new Date(date_selected * 1000);
            service_item_start_time.setHours(Number(over_time[0]));
            service_item_start_time.setMinutes(Number(over_time[1]));
            service_item_start_time = Math.floor(service_item_start_time / 1000);
            $('.sumbit_btn').show();
        }
    });

    $('.continue_btn').on('click', function() {
        customer_name = $('#customer_name').val();
        customer_tel = $('#customer_tel').val();
        userid = $('#userid').val();

        console.debug(staff_id+','+service_item_id+','+service_item_start_time+','+customer_name+','+customer_tel);

        $('.customer_info_modal').modal('hide');
        $('.waiting_modal').modal({backdrop: 'static', keyboard: false});

        __ajax("orders.add", {staff_id: staff_id, service_id: service_item_id, start_time: service_item_start_time,customer_name: customer_name, customer_tel: customer_tel, userid: userid}, function() {success_sumbit();}, function() {fail_sumbit();});
    });

    $('.sumbit_btn').on('click', function() {
        if(customer_name == null || customer_tel == null) {
            $('.customer_info_modal').modal({backdrop: 'static', keyboard: false});
        } else {
            console.debug(staff_id+','+service_item_id+','+service_item_start_time+','+customer_name+','+customer_tel);

            $('.waiting_modal').modal({backdrop: 'static', keyboard: false});

            __ajax("orders.add", {staff_id: staff_id, service_id: service_item_id, start_time: service_item_start_time,customer_name: customer_name, customer_tel: customer_tel}, function() {success_sumbit();}, function() {fail_sumbit();});
        }
    });

    $('.success_modal').on('hide.bs.modal', function () {
        location.reload();
    });
});

function init_data() {
    for(i in staff_services) {
        staffs_list[staff_services[i]['staff_id']] = staff_services[i]['service_id'];
        var services = staff_services[i]['service_id'].split(',');
        for(j in services) {
            if(typeof(service_items_list[services[j]]) == 'undefined') {
                service_items_list[services[j]] = staff_services[i]['staff_id'];
            } else {
                service_items_list[services[j]] += ',' + staff_services[i]['staff_id'];
            }
        }
    }

    for(i in duties) {
        var _staff_id = duties[i]['summary']['staff_id'];
        var _type = duties[i]['summary']['type'];
        var _rule = duties[i]['summary']['rule'].split(',');
        var _vacation = JSON.parse(duties[i]['summary']['vacation']);
        var _rest = false;
        for(j in timestamps) {
            var _now = new Date(timestamps[j] * 1000);
            if(_type == 1) {
                for(m in _rule) {
                    if(_rule[m] == _now.getDay()) {
                        _rest = true;
                    }
                }
            } else if(_type == 2) {
                var _rule_start_time = new Date(Date.parse(_rule[2].replace(/-/g,   "/"))).getTime();
                var _dates = Math.abs((timestamps[j] * 1000 - _rule_start_time)) / (1000 * 60 * 60 * 24);
                if(_dates % (_rule[0] + _rule[1]) < _rule[0]) {
                } else if(_dates % (_rule[0] + _rule[1]) > _rule[1]) {
                    _rest = true;
                }
            } else {
            }
            if(_vacation && typeof(_vacation[timestamps[j]]) != 'undefined') {
                if(event_settings[_vacation[timestamps[j]]['type']]['type'] == 1){ 
                    _rest = true;
                } else if(event_settings[_vacation[timestamps[j]]['type']]['type'] == 2) {
                    _rest = false;
                }
            }
            if(_rest) {
                vacation_list[timestamps[j]].push(_staff_id);
            }
        }
    }

    for(i in orders) {
        var _staff_id = orders[i]['summary']['staff_id'];
        var _service_id = orders[i]['summary']['service_id'];
        var _start_time = orders[i]['summary']['start_time'];
        var _waste_time = Number(service_items[_service_id]['summary']['service_time']) + Number(2 * service_items[_service_id]['summary']['interval_time']);
        var _time_part = new Array();
        _time_part['start_time'] = _start_time;
        _time_part['waste_time'] = _waste_time;
        if(typeof(time_select_list[timestamps[0]][_staff_id]) == 'undefined') {
            time_select_list[timestamps[0]][_staff_id] = new Array();
        }
        if(_start_time > timestamps[0] && _start_time < timestamps[1]) {
            if(typeof(time_select_list[timestamps[0]][_staff_id]) == 'undefined') {
                time_select_list[timestamps[0]][_staff_id] = new Array();
            }
            time_select_list[timestamps[0]][_staff_id].push(_time_part);
        } else if(_start_time < timestamps[2]) {
            if(typeof(time_select_list[timestamps[1]][_staff_id]) == 'undefined') {
                time_select_list[timestamps[1]][_staff_id] = new Array();
            }
            time_select_list[timestamps[1]][_staff_id].push(_time_part);
        } else if(_start_time < timestamps[3]) {
            if(typeof(time_select_list[timestamps[2]][_staff_id]) == 'undefined') {
                time_select_list[timestamps[2]][_staff_id] = new Array();
            }
            time_select_list[timestamps[2]][_staff_id].push(_time_part);
        } else if(_start_time < timestamps[4]) {
            if(typeof(time_select_list[timestamps[3]][_staff_id]) == 'undefined') {
                time_select_list[timestamps[3]][_staff_id] = new Array();
            }
            time_select_list[timestamps[3]][_staff_id].push(_time_part);
        } else if(_start_time > timestamps[4] && _start_time < (timestamps[4] + 86400)){
            if(typeof(time_select_list[timestamps[4]][_staff_id]) == 'undefined') {
                time_select_list[timestamps[4]][_staff_id] = new Array();
            }
            time_select_list[timestamps[4]][_staff_id].push(_time_part);
        }
    }
}

function count_service_item() {
    var count_number = $('#service_items_list').find('.item_show').length - $('#service_items_list').find('.item_show.hide').length;
    return count_number;
}

function count_staff() {
    var count_number = $('#staffs_list').find('.item_show').length - $('#staffs_list').find('.item_show.on_vacation').length - $('#staffs_list').find('.item_show.hide').length + $('#staffs_list').find('.item_show.on_vacation.hide').length;
    return count_number;
}

function hide_staff_on_vacation() {
    $('.item_show').removeClass('on_vacation');
    for(i in vacation_list[date_selected]) {
        $('#staff-' +  vacation_list[date_selected][i]).addClass('on_vacation');
    }
}

function toggle_staff_result() {
    if(staff_selected) {
        $('#staff_div').find('.result_waiting').hide();
        $('#staff_div').find('.result_intro').show();
        $('#staff_div').find('.result_show').show();
        $('#staff_div').find('.result_show').text($('#staff_div').find('.item_show.active').attr('title'));
    } else {
        $('#staff_div').find('.result_waiting').show();
        $('#staff_div').find('.result_intro').hide();
        $('#staff_div').find('.result_show').hide();
        $('#staff_div').find('.result_show').text('');
    }
}

function toggle_service_item_result() {
    if(service_item_selected) {
        $('#service_item_div').find('.result_waiting').hide();
        $('#service_item_div').find('.result_intro').show();
        $('#service_item_div').find('.result_show').show();
        $('#service_item_div').find('.result_show').text($('#service_item_div').find('.item_show.active').attr('title'));
    } else {
        $('#service_item_div').find('.result_waiting').show();
        $('#service_item_div').find('.result_intro').hide();
        $('#service_item_div').find('.result_show').hide();
        $('#service_item_div').find('.result_show').text('');
    }
}

function toggle_time_select() {
    if(service_item_selected && staff_selected) {
        $('.staff_null').hide();
        $('.time_select').show();
        $('.time_block').removeClass('in_use');
        $('.time_block').removeClass('selected');
        for(i in time_select_list[date_selected][staff_id]) {
            var hour = new Date(time_select_list[date_selected][staff_id][i]['start_time'] * 1000).getHours();
            var minute = new Date(time_select_list[date_selected][staff_id][i]['start_time'] * 1000).getMinutes();
            var service_time = time_select_list[date_selected][staff_id][i]['waste_time'];
            for(var i = 0; i < service_time / 10; i++) {
                $('#'+hour+'-'+minute).addClass('in_use');
                minute += 10;
                if(minute >= 60) {
                    hour++;
                    minute = 0;
                }
            }
        }
    } else {
        $('.staff_null').show();
        $('.time_select').hide();
        $('.sumbit_btn').hide();
    }
    // TODO: Draw a timetable for selected staff
}

function change_first() {
    if(switch_flag == SERVICE_ITEM_FIRST) {
        var div_width = $('#time_div').offset().left / 2;
        $('#service_item_div').animate({left: div_width});
        $('#staff_div').animate({left: -div_width});
        $('#service_item_switch_btn').hide();
        $('#staff_switch_btn').show();

        $('#service_item_switch_btn').popover('hide');
        $('.item_show.hide').removeClass('hide');
        $('#service_items_list').find('.item_show').removeClass('btn-primary');
        $('#service_items_list').find('.item_show').removeClass('active');
        $('#service_item_number').text(count_service_item());
        $('#staff_number').text(count_staff());

        toggle_service_item_result();
        switch_flag =  STAFF_FIRST;
    } else {
        $('#service_item_div').animate({left: 0});
        $('#staff_div').animate({left: -0});
        $('#service_item_switch_btn').show();
        $('#staff_switch_btn').hide();

        $('.item_show.hide').removeClass('hide');
        $('#staff_switch_btn').popover('hide');
        $('.item_show.hide').removeClass('hide');
        $('#staffs_list').find('.item_show').removeClass('btn-primary');
        $('#staffs_list').find('.item_show').removeClass('active');
        $('#staff_number').text($('#staffs_list').find('.item_show').length);
        $('#service_item_number').text(count_service_item());
        $('#staff_number').text(count_staff());

        toggle_staff_result();
        switch_flag =  SERVICE_ITEM_FIRST;
    }
}

function success_sumbit() {
    $('.waiting_modal').modal('hide');
    $('#success-service_item').text($('#service_item_div').find('.result_show').text());
    $('#success-staff').text($('#staff_div').find('.result_show').text());
    $('#success-time').text($('.date_show').text());
    $('.success_modal').modal('show');
}

function fail_sumbit() {
    $('.waiting_modal').modal('hide');
    $('.fail_modal').modal('show');
}