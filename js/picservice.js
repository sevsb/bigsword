function get_pic_url(functionname) {
    $.ajax({    //get pic_url
        url: "ajax.php?action=" + 'picservice.get_pic_url',
        type: 'post',
        data: {},
        success: function (data) {
            data = eval("(" + data + ")");
            pic_url = data.ret;
            console.log("pic_url:"+pic_url);
            functionname(data);
        }
    });
}

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
            console.debug('token:' + token);
            console.debug('expired:' + expired);
            console.debug('now_time:' + now_time);
            if (now_time > expired || token == null) {
                refresh_picservice_token();
            }
        }
    });
}

function upload_image(img_src,functionname) {   //现阶段只能接受第二个必须为function(data){}

    var now_time = Date.parse(new Date()) / 1000;
    if (now_time > expired) {
        console.log('now to refresh token');
        refresh_picservice_token();
    }
    
    console.log('---now start to upload img---');
    console.log(token);
    console.log(expired);
    get_pic_url(function(){
        $.ajax({    //上传图片
            url: pic_url + "ajax.php?action=" + 'picservice.upload_image',
            type: 'post',
            data: {token: token ,img_src: img_src},
            success: function (data) {
                console.log(data);
                functionname(data);
            }
        });
    });
}


function refresh_picservice_token() {
    console.log('refresh_picservice_token!');
    url_path = get_url_path();
    console.log(url_path);
    get_pic_url(function(){
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
    });
    
}