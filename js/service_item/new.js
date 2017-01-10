$(document).ready(function() {
    
    //code = null;
    check_picservice_token();
    //console.log(code);
    $('.upload_btn').click(function (){
        $("#upload_input").click();
    });
    

    $("#upload_input").change(function() {
        if (typeof FileReader == 'undefined') {
            alert("您的浏览器不支持上传，请更换浏览器重试！");
            return false;
        }

        var file = this.files[0];
        if (!/image\/\w+/.test(file.type)) {
            alert("文件不是图像类型！");
            return false;
        }
        
        var reader = new FileReader();
        reader.onload = function(e){
            var img_src = e.target.result;
            
           
            
            var now_time = Date.parse(new Date()) / 1000;
            if (now_time > expired) {
                console.log('now to refresh token');
                refresh_picservice_token();
            }
            
            console.log(token);
            console.log(expired);
            
            $.ajax({    //上传图片
                url: pic_url + "ajax.php?action=" + 'picservice.upload_image',
                type: 'post',
                data: {token: token ,img_src: img_src},
                success: function (data) {
                    data = eval("(" + data + ")");
                    console.debug(data);
                    if (data.ret == 'token authorise failed') {
                        alert(data.ret);
                        refresh_picservice_token();
                        return;
                    }
                    
                    if (data.status == 'success') {
                        var img_drone = "<img src='" + img_src +"' style='width: 100px;' filename=" + data.info + ">";
                        $('.previews').append(img_drone);
                        
                    } else if (data.status == 'fail') {
                        alert(data.info);
                    }
                    //
                    //var token = data.token;
                    //var expired = data.expired;
                    //console.debug(data);
                    //console.debug(expired);
                    
                } 
            });
            
            
        }
        reader.readAsDataURL(file);
        return true;
    });

    
    
    
    
});

