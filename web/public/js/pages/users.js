function getInitialUsersInformation() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "./src/Api/v1.php?getAllUsers",
            success: function(data) {
                resolve(data);
            },
            error: function(error) {
                reject(error);
            }
        });
    });
}

function getInitialUsersInformation() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "./src/Api/v1.php?getAllUsers",
            success: function(data) {
                resolve(data);
            },
            error: function(error) {
                reject(error);
            }
        });
    });
}

getInitialUsersInformation().then((data) => {
    let users;
    let role;
    if (typeof data === 'string') {
        users = JSON.parse(data);
    } else {
        users = data;
    }

    let tableContent = `
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">ID</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Логин</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Права</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">`;

    users.forEach(user => {

        if(user.role == "admin") {
            role = `<p class="rounded-md w-min whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset text-rose-700 bg-rose-50 ring-rose-600/20 font-onest">Администратор</p>`
        } else {
            role = `<p class="rounded-md w-min whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset text-blue-700 bg-blue-50 ring-blue-600/20 font-onest">Пользователь</p>`
        }

        tableContent += `
            <tr class="even:bg-gray-50">
                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">${user.identity}</td>
                <td class="px-3 py-4 text-sm text-gray-500">${user.login}</td>
                <td class="px-3 py-4 text-sm text-gray-500">${role}</td>
                <td class="px-3 py-4 text-sm text-gray-500">
                    <button class="delete-user border border-rose-600/20 bg-rose-50 p-2 rounded-md hover:opacity-80 transition-all" data-user-id="${user.identity}">
                        <svg class="w-4 h-4 text-rose-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                        </svg>
                    </button>
                </td>
            </tr>`;
    });

    tableContent += `
                    </tbody>
                </table>
            </div>
        </div>`;

    $(".users-block").html(tableContent);
    attachDeleteHandlers();
});

function attachDeleteHandlers() {
    $('.delete-user').on('click', function() {
        let userId = $(this).data('user-id');
        
        Swal.fire({
            title: 'Вы уверены?',
            text: "Это действие нельзя будет отменить!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Я уверен",
            cancelButtonText: 'Отменить'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteUser(userId).then((data) => {
                    if (isJSON(data)) {
                        if (JSON.parse(data)["response"] == "success") {
                            addNotification("Успех", "Вы успешно удалили учетную запись!", "Success");
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    } else {
                        appendDivWithScript(data);
                    }
                });
            }
        });
    });
}

$(".register-new-user").click(() => {
    Swal.fire({
        title: 'Создание новой учетной записи',
        html: `<input type="text" class="swal2-input newUserLogin p-2 w-[80%] text-sm border-2 border-gray-300 rounded-md" placeholder="Логин">
                <select class="swal2-select newUserGroup p-2 w-[80%] !text-sm border-2 border-gray-300 rounded-md mt-2">
                    <option value="user">Пользователь</option>
                    <option value="admin">Администратор</option>
                </select>
                <input type="password" class="swal2-input newUserPassword p-2 w-[80%] text-sm border-2 border-gray-300 rounded-md mt-2" placeholder="Пароль">`,

        showCancelButton: true,
        confirmButtonText: 'Сохранить',
        cancelButtonText: 'Закрыть',
        preConfirm: () => {
            const login = Swal.getPopup().querySelector('.newUserLogin').value;
            const role = Swal.getPopup().querySelector('.newUserGroup').value;
            const password = Swal.getPopup().querySelector('.newUserPassword').value;

            if (!login || !password) {
                Swal.showValidationMessage(`Введите логин, пароль и выберите группу пользователя`);
            }
            return { login: login, role: role, password: password }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { login, role, password } = result.value;

            createNewUser(login, role, password).then((data) => {
                if (isJSON(data)) {
                    if (JSON.parse(data)["response"] == "success") {
                        addNotification("Успех", "Новый пользователь создан!", "Success");
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                } else {
                    appendDivWithScript(data);
                }
            });
        }
    });
});

function deleteUser(userId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "./src/Api/v1.php?deleteUser",
            data: {
                userId: userId
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

function createNewUser(login, role, password) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "./src/Api/v1.php?createNewUser",
            data: {
                login: login,
                password: password,
                role: role
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