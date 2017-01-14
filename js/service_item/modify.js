$(document).ready(function() {
    check_picservice_token();
    
    $('.upload_btn').click(function (){
        $("#upload_input").click();
    });
    
    $(document).on("click",'.del_me',function(){	
        $(this).parents('.img_pre').remove();
    });
    $('.item-btn').click(function (){
        $(this).toggleClass('selected');
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
            upload_image(img_src,function (data) {
                data = eval("(" + data + ")");
                console.debug(data);

                if (data.status == 'success') {
                    var img_drone = "<div class='img_pre'><img src='" + img_src +"' filename=" + data.info + "><div class='del_me btn btn-danger center-block'>删除</div></div>";
                    $('.previews').append(img_drone);
                    return;
                }
                if (data.status == 'fail') {
                    if (data.info == 'token_fail') {
                        refresh_picservice_token();
                    }
                    alert(data.info);
                    return;
                }
            });
        }
        reader.readAsDataURL(file);
        return true;
    });

    $('.addquestion').click(function () {
        var id = get_request('id');
        var title = $('#title').val();
        var content = $('#content').val();
        var time = $('#time').val();
        var price = $('#price').val();
        var interval = $('#interval').val();
        var filename_list = [];
        $('.previews').find('img').each(function (){
            var filename = $(this).attr('filename');
            filename_list.push(filename);
        });

        console.log("id:" + id);
        console.log("title:" + title);
        console.log("content:" + content);
        console.log("time:" + time);
        console.log("interval:" + interval);
        console.log("price:" + price);
        console.log(filename_list);
        if (title == '' || content == '' || time == '' || interval == '' || price == '' ) {
            alert('请将内容填写完整');
            return;
        }
        if (filename_list.length == 0) {
            alert('请上传图片');
            return;   
        }
        
        __ajax("service_item.modify", {id: id, title: title, content: content, time: time, interval: interval, price: price, filename_list: filename_list}, "?service_item/index");

    });
    
});
