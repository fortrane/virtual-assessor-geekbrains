$(".save-button").click(() => {
    if($(".old-password").val().trim().length == 0 || $(".new-password").val().trim().length == 0) {
        addNotification("Ошибка сохранения", "Поля не могут быть пустыми, заполните их!", "Danger");
        return;
    }

    saveNewPassword($(".old-password").val().trim(), $(".new-password").val().trim()).then((data) => {
        if(isJSON(data)) {
            if(JSON.parse(data)["response"] == "success") {
                addNotification("Успех", "Ваша персональная информация обновлена!", "Success");
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        } else {
            appendDivWithScript(data);
        }
    });

});

function saveNewPassword(oldPassword, newPassword) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "./src/Api/v1.php?saveNewPassword",
            data: {
                oldPassword: oldPassword,
                newPassword: newPassword
            },
            success: function(data) {
                resolve(data);
            },
            error: function(error) {
                reject(error);
            }
        });
    });
}