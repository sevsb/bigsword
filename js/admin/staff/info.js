$(document).ready(function() {

    $('.upload_btn').click(function () {
        $("#upload_input").click();
        return false;
    });
    
    $('.upload_btn1').click(function () {
        $("#upload_input").click();
        return false;
    });
    
    $('.do_del').click(function () {
        var staff_id = $('.staff_id').html();
        console.log(staff_id);
        __ajax('admin.staff.del', {id: staff_id},function(){
            document.location.href = '?admin/staff/index';
        });
    });
    
    $('.item-btn').click(function (){
        $(this).toggleClass('btn-selected');
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
            // upload_image(img_src,function (data) {
            //     data = eval("(" + data + ")");
            //     console.debug(data);

            //     if (data.status == 'success') {
            //         var img_drone = "<div class='img_pre'><img src='" + img_src +"' filename=" + data.info + "><button class='del_me btn btn-danger center-block'>删除</button></div>";
            //         $('.previews').append(img_drone);
            //         return;
            //     }
            //     if (data.status == 'fail') {
            //         if (data.info == 'token_fail') {
            //             refresh_picservice_token();
            //         }
            //         alert(data.info);
            //         return;
            //     }
            // });
        }
        reader.readAsDataURL(file);
        return true;
    });

    $('.submit_btn').click(function () {
        var action = $(this).attr("action");

        var staff_id = $("#staff_id").val();
        var name = $('#name').val();
        var content = $('#content').val();
        var skills = [];
        $('.btn-selected').each(function() {
            var skill = $(this).attr('id');
            skills.push(skill);
        });

        var photo = $("#photo").attr("src");
        
        console.log("name:" + name);
        console.log("content:" + content);
        console.log(skills);
        
        if (name == '' || content == '' ) {
            alert('请将内容填写完整');
            return;
        }
        if (skills.length == 0) {
            alert('请选择技师技能');
            return;   
        }
        if (photo.length == 0) {
            alert('请上传图片');
            return;   
        }

        __ajax(action, {staff_id: staff_id, name: name, content: content, skills: skills, photo: photo}, "?admin/staff/index");
        // __ajax("servers.add", {name: name, content: content, skills: skills, filename_list: filename_list}, "?servers/index");
    });
});

