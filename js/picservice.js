pic_url = "http://180.76.160.113/picservice/";

function check_picservice_token() {
    console.log('check_picservice_token!');
    $.ajax({    //读取token
        url: "ajax.php?action=" + 'picservice.get_token',
        type: 'post',
        data: {},
        success: function (data) {
            //console.debug('get_token');
            data = eval("(" + data + ")");
            var now_time = Date.parse(new Date()) / 1000;
            token = data.token;
            expired = data.expired;

            console.debug(token);
            console.debug(expired);
            console.debug(now_time);
            if (now_time > expired || token == null) {
                refresh_picservice_token();
            }
        }
    });
}

function upload_image() {

    var now_time = Date.parse(new Date()) / 1000;
    if (now_time > expired) {
        console.log('now to refresh token');
        refresh_picservice_token();
    }
    
    console.log(token);
    console.log(expired);
    
    $.ajax({    //发送token
        url: pic_url + "ajax.php?action=" + 'picservice.send_token',
        type: 'post',
        data: {token: token ,expired: expired},
        success: function (data) {
            console.debug(data);

            //data = eval("(" + data + ")");
            //var token = data.token;
            //var expired = data.expired;
            //console.debug(data);
            //console.debug(expired);
            
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
                url: pic_url + "ajax.php?action=" + 'picservice.request_token',
                type: 'post',
                data: {code: code ,host: url_path},
                success: function (data) {
                    data = eval("(" + data + ")");
                    console.debug(data);
                    if(data.ret == 'failed') {
                        alert('token获取失败！');
                        return;
                    }
                    
                    token = data.token;
                    expired = data.expired;
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