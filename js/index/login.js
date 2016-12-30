$(document).ready(function() {
    $("#do-login").click(function() {
        var salt = "[:salt]";
        var email = $("#email").val();
        var password = $("#password").val();
        var cipher = md5(email + salt + password);

         console.debug("email = " + email);
         console.debug("password = " + password);
         console.debug("salt = " + salt);
         console.debug("cipher = " + cipher);

        __ajax("login.login", {email: email, cipher: cipher}, function(data) {
            document.location.href = '?main/main';
        });
    });
});
