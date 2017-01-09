function check_picservice_token() {
    console.log('check_picservice_token!');
    $.ajax({    //读取token
        url: "ajax.php?action=" + 'picservice.get_token',
        type: 'post',
        data: {},
        success: function (data) {
            //console.debug('get_token');
            data = eval("(" + data + ")");
            expired = data.expired;
            console.debug(data.expired);
            var now_time = Date.parse(new Date()) / 1000;
            console.debug(now_time);
            token = data.token;
            if (now_time > expired) {
                refresh_picservice_token();
            }
        }
    });
}


function refresh_picservice_token() {
    console.log('refresh_picservice_token!');
    url_path = get_url_path();
    console.log(url_path);
    $.ajax({    //拿到当前的code
        url: "ajax.php?action=" + 'picservice.get_code',
        type: 'post',
        data: {},
        success: function (data) {
            console.debug(data);
            data = eval("(" + data + ")");
            console.debug(data.value);
            code = data.value;
            
            $.ajax({    //获取新的token
                url: "http://127.0.0.1/picservice/ajax.php?action=" + 'picservice.request_token',
                type: 'post',
                data: {code: code ,host: url_path},
                success: function (data) {
                    console.debug(data);

                    data = eval("(" + data + ")");
                    var token = data.token;
                    var expired = data.expired;
                    //console.debug(data);
                    //console.debug(expired);
                    
                        $.ajax({    //存入token
                            url: "ajax.php?action=" + 'picservice.save_token',
                            type: 'post',
                            data: {token: token ,expired: expired},
                            success: function (data) {
                                console.debug(data);
                            }
                        });
                }
            });
        }
    });
    
}