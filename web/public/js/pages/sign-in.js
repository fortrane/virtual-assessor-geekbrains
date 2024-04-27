function tryToAuthUser() {
    $.ajax({
        type: "POST",
        url: "./src/Api/v1.php?authUser",
        data: {
            login: $('.login-input').val(),
            password: $('.password-input').val()
        },
        success: function(html) {
            appendDivWithScript(html);
        }
    });
}

$(".sign-in-form").submit((e) => {
    e.preventDefault();
    tryToAuthUser();
});