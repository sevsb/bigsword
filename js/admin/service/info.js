$(document).ready(function() {

    $('.upload_btn').click(function () {
        $("#upload_input").click();
        return false;
    });
    
    $('.upload_btn1').click(function () {
        $("#upload_input").click();
        return false;
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

        $(".upload_btn").addClass("hidden");
        $("#photo").removeClass("hidden");

        var reader = new FileReader();
        reader.onload = function(e) {
            var img_src = e.target.result;
            $("#photo").attr("src", img_src);
        }
        reader.readAsDataURL(file);
        return true;
    });

    $('.submit_btn').click(function () {
        var action = $(this).attr("action");
        var service_id = $("#service-id").val();
        var title = $('#title').val();
        var content = $('#content').val();
        var photo = $("#photo").attr("src");

        console.log("action:" + action);
        console.log("title:" + title);
        console.log("content:" + content);

        if (title == '' || content == '') {
            alert('请将内容填写完整');
            return;
        }

        if (photo.length == 0) {
            alert('请上传图片');
            return;
        }

        __ajax(action, {service_id: service_id, title: title, content: content, photo: photo}, "?admin/service/index");
        // __ajax("service_item.add", {title: title, content: content, time: time, interval: interval, price: price, filename_list: filename_list}, "?service_item/index");
    });

});
