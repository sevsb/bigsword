$(document).ready(function() {

    $('.sumbit_btn').click(function () {
        var name = $('#name').val();
        var tel = $('#tel').val();
        
        console.log("name:" + name);
        console.log("tel:" + tel);

        if (name == '' || tel == '' ) {
            alert('请将内容填写完整');
            return;
        }

        __ajax("customers.add", {name: name, tel: tel}, "?customers/index");
    });

});