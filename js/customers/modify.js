$(document).ready(function() {

    $('.addquestion').click(function () {
        var id = get_request('id');
        var name = $('#name').val();
        var tel = $('#tel').val();
        
        console.log("name:" + name);
        console.log("tel:" + tel);

        if (name == '' || tel == '' ) {
            alert('请将内容填写完整');
            return;
        }
        
        __ajax("customers.modify", {id: id, name: name, tel: tel}, "?customers/index");
    });
    
});