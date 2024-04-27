document.addEventListener('DOMContentLoaded', function () {

    observer.observe(document.querySelector('.material-block'), {
        childList: true,
        subtree: true
    });

    observer.observe(document.querySelector('.questions-list'), {
        childList: true,
        subtree: true
    });

    const dropzoneElement = document.querySelector('#dropzone-file');

    if (!dropzoneElement.dropzone) {
        new Dropzone(dropzoneElement, {
            url: "./src/Api/v1.php?uploadNewMaterial",
            paramName: "file",
            acceptedFiles: ".docx",
            maxFiles: 1,
            clickable: true,
            autoProcessQueue: false,
            previewsContainer: false,

            init: function() {
                this.on("addedfile", function(file) {
                    const materialNameInput = document.querySelector('.material-name-input').value.trim();
                    if (!materialNameInput) {
                        addNotification("Ошибка", "Введите название материала", "Danger");
                        this.removeFile(file);
                        return;
                    }

                    this.on("sending", function(file, xhr, formData) {
                        formData.append('materialName', materialNameInput);
                    });

                    this.processFile(file);
                });

                this.on("success", function(file, response) {
                    response = JSON.parse(response);
                    if (response.status === "success") {
                        addNotification("Успешно", "Материал успешно загружен", "Success");
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        addNotification("Ошибка", "Произошла ошибка: " + response.message, "Danger");
                    }
                });

                this.on("error", function(file, errorMessage) {
                    addNotification("Ошибка", errorMessage, "Danger");
                    this.removeFile(file);
                });

                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            }
        });
    }


    $.ajax({
        url: "./src/Api/v1.php?getAllMaterial",
        type: "GET",
        success: function(data) {
            let materials = data;

            let tableContent = `
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Название материала</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Дата загрузки</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">`;

            materials.forEach(function(material) {
                tableContent += `
                    <tr class="even:bg-gray-50">
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">${material.materialName}</td>
                        <td class="px-3 py-4 text-sm text-gray-500">${material.uploadDate}</td>
                        <td class="px-3 py-4 text-sm text-gray-500">
                            <button class="view-material border border-indigo-600/20 bg-indigo-50 p-2 rounded-md hover:opacity-70 transition-all open-modal-button" data-modal-target="#viewMaterial" material-id="${material.identity}">
                                <svg class="w-4 h-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"></path>
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

            $('.material-block').empty().html(tableContent);
        },
        error: function(xhr, status, error) {
            console.error("Ошибка при получении данных: " + error);
        }
    });

    $('.create-questions-button').click(function() {
        var materialId = $(this).attr('material-id');

        if (!materialId) {
            addNotification("Ошибка", "Произошла ошибка: Неверный ID материала", "Danger");
            return;
        }

        $.ajax({
            url: './src/Api/v1.php?createQuestions',
            type: 'POST',
            data: {
                materialId: materialId
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    addNotification("Успех", "Запрос успешно отправлен!", "Success");
                    location.reload();
                } else {
                    alert(data.message);
                    addNotification("Ошибка", data.message, "Danger");
                }
            },
            error: function(xhr, status, error) {
                addNotification("Ошибка", "Произошла ошибка: " + error, "Danger");
                alert('Error: ' + error);
            }
        });
    });

    $('.generate-test-button').click(function() {
        var materialId = $(this).attr('material-id');

        if (!materialId) {
            addNotification("Ошибка", "Произошла ошибка: Неверный ID материала", "Danger");
            return;
        }

        $.ajax({
            url: './src/Api/v1.php?createTest',
            type: 'POST',
            data: {
                materialId: materialId
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    /* alert(data.message); */
                    addNotification("Успех", "Запрос успешно отправлен!", "Success");
                    location.reload();
                } else {
                    /* alert(data.message); */
                    addNotification("Ошибка", data.message, "Danger");
                }
            },
            error: function(xhr, status, error) {
                addNotification("Ошибка", "Произошла ошибка: " + error, "Danger");
                alert('Error: ' + error);
            }
        });
    });

});

function loadMaterialData(materialId) {
    $.post('./src/Api/v1.php?getSpecificMaterialData', { materialId: materialId }, function(response) {
        if (response.status === 'success') {
            const material = response.material;

            $(".generate-test-button").attr("material-id", materialId);
            $(".create-questions-button").attr("material-id", materialId);

            $('.material-name-title').text(material.materialName);

            if (material.questions && material.questions.length > 0) {
                let questionsHtml = `
                <table class="min-w-full divide-y divide-gray-300 ">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Вопрос</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ответ</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                `;

                material.questions.forEach(question => {
                    questionsHtml += `
                    <tr class="even:bg-gray-50">
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3 text-left">${question.question}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 text-left">${question.answer}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 text-left">
                            <button class="delete-question border border-rose-600/20 bg-rose-50 p-2 rounded-md hover:opacity-80 transition-all" data-id="${question.id}">
                                <svg class="w-4 h-4 text-rose-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    `;
                });

                questionsHtml += `</tbody></table>`;
                $('.questions-list').html(questionsHtml);
            } else {
                $('.questions-list').html(`<div class="bg-[#f1f3f4] rounded-[8px] justify-center flex items-center h-[200px] animate-pulse mt-2"> <div class="grid justify-center items-center justify-items-center"> <div> <span class="text-[16px] font-medium text-[#b8b8b8]">Пока тут ничего нет</span> </div> <div> <svg class="text-[#b8b8b8] w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path> </svg> </div> </div> </div>`);
            }

            if (material.testJson && material.testJson.length > 0) {
                const tests = JSON.parse(material.testJson.replace(/'/g, '"'));
                let testsHtml = `
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Вопрос</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ответы</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Верный ответ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                `;

                tests.forEach((test, index) => {
                    let questionKey = `question`;
                    let question = test[questionKey];
                    let answers = [test.answer1, test.answer2, test.answer3, test.answer4].join(', ');
                    let rightAnswer = test.right;

                    testsHtml += `
                    <tr class="even:bg-gray-50">
                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3 text-left">${question}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 text-left">${answers}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 text-left">${rightAnswer}</td>
                    </tr>
                    `;
                });

                testsHtml += `</tbody></table>`;
                $('.test-list').html(testsHtml);
            } else {
                $('.test-list').html(`<div class="bg-[#f1f3f4] rounded-[8px] justify-center flex items-center h-[200px] animate-pulse mt-2"> <div class="grid justify-center items-center justify-items-center"> <div> <span class="text-[16px] font-medium text-[#b8b8b8]">Пока тут ничего нет</span> </div> <div> <svg class="text-[#b8b8b8] w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path> </svg> </div> </div> </div>`);
            }
        } else {
            console.error('Failed to load material data:', response.message);
        }
    }, 'json');
}

function setupListeners() {
    $('.view-material').off('click');

    $('.view-material').on('click', function() {
        const materialId = $(this).attr('material-id');
        loadMaterialData(materialId);
    });
}

const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
            setupListeners();
            setupDeleteListeners();
        }
    });
});

function setupDeleteListeners() {
    document.querySelectorAll('.delete-question').forEach(button => {
        button.removeEventListener('click', handleDeleteQuestion);
        button.addEventListener('click', handleDeleteQuestion);
    });
}

function handleDeleteQuestion(event) {
    const questionId = event.target.getAttribute('data-id');
    const materialId = $(".generate-test-button").attr("material-id");

    if (!questionId) {
        console.error('Invalid question ID');
        return;
    }

    $.ajax({
        url: './src/Api/v1.php?deleteSpecificQuestion',
        type: 'POST',
        data: {
            questionId: questionId
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === "success") {
                addNotification("Успех", "Вопрос успешно удален!", "Success");
                loadMaterialData(materialId);
            } else {
                addNotification("Ошибка", "Произошла ошибка при удалении вопроса: " + data.message, "Danger");
            }
        },
        error: function(xhr, status, error) {
            addNotification("Ошибка", "Произошла ошибка AJAX запроса: " + error, "Danger");
        }
    });
}