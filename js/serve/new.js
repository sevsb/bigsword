$(document).ready(function() {
    
    code = null;
    check_picservice_token();
    console.log(code);
    $('.upload_btn').click(function (){
        $("#upload_input").click();
        console.log(code);
        console.log(token);
    });
    

    $("#upload_input").change(function() {
        if (typeof FileReader == 'undefined') {
            alert("�����������֧���ϴ����������������ԣ�");
            return false;
        }

        var file = this.files[0];
        if (!/image\/\w+/.test(file.type)) {
            alert("�ļ�����ͼ�����ͣ�");
            return false;
        }

        var reader = new FileReader();
        reader.onload = function(e){
            $("#face").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
        return true;
    });

    
    
    
    
});

