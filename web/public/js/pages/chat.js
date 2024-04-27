let lastDataLength = 0;

$(document).ready(() => {
    setInterval(getChatHistory, 1000);
    initListeners()
});

function getChatHistory() {
    $.ajax({
        type: "GET",
        url: "./src/Api/v1.php?getChatHistory",
        success: function(data) {

            if(data == null) {
                let chatBlock = $('.chat-block');
                chatBlock.html(`<div class="bg-[#f1f3f4] rounded-[8px] justify-center flex items-center h-[200px] animate-pulse mt-2"> <div class="grid justify-center items-center justify-items-center"> <div> <span class="text-[16px] font-medium text-[#b8b8b8]">Пока тут ничего нет</span> </div> <div> <svg class="text-[#b8b8b8] w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path> </svg> </div> </div> </div>`);
            }

            if (data.length !== lastDataLength) {
                renderChat(data);
                checkAndToggleInput(data);
                lastDataLength = data.length;
            }
        }
    });
}

function initListeners() {
    $('.send-new-message-button').on('click', sendUserMessage);
    $('.material-change-button').on('click', changeChatContext);
    
    loadMaterials();
}

function changeChatContext() {
    var selectedMaterialId = $('.material-select').val();
    if (!selectedMaterialId) {
        addNotification("Ошибка", "Пожалуйста, выберите материал", "Danger");
        return;
    }

    $.ajax({
        type: "POST",
        url: "./src/Api/v1.php?changeChatContext",
        data: {
            materialId: selectedMaterialId
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === "success") {
                addNotification("Успех", "Контекст чата успешно изменен", "Success");
            } else {
                addNotification("Ошибка", "Произошла ошибка при изменении контекста: " + response.message, "Danger");
            }
        },
        error: function() {
            addNotification("Ошибка", "Произошла ошибка со стороны сервера", "Danger");
        }
    });
}

function sendUserMessage() {
    var messageText = $('.message-input').val().trim();
    if (messageText === '') {
        addNotification("Ошибка", "Пожалуйста, введите сообщение", "Danger");
        return;
    }

    $('.message-input').val('');

    $.ajax({
        type: "POST",
        url: "./src/Api/v1.php?sendUserMessage",
        data: {
            answerText: messageText
        },
        success: function(response) {
            /* response = JSON.parse(response); */
            response = response;
            /* if (response.status === "success" || response.status === "test") {
                addNotification("Успех", "Ваше сообщение успешно отправлено", "Success");
            } else {
                addNotification("Ошибка", "Произошла ошибка при отправке сообщения: " + response.message, "Danger");
            } */
        },
        error: function() {
            addNotification("Ошибка", "Произошла ошибка со стороны сервера", "Danger");
        }
    });
}

function validateTest(testId) {
    let answers = [];
    let allQuestionsAnswered = true;

    const allQuestions = document.querySelectorAll('.last-test .grid');
    allQuestions.forEach((questionBlock, index) => {
        const checkedInput = questionBlock.querySelector('input[type="radio"]:checked');
        if (checkedInput) {
            answers.push({
                questionId: checkedInput.getAttribute('question-id'),
                answerId: checkedInput.getAttribute('answer-id')
            });
        } else {
            allQuestionsAnswered = false;
        }
    });

    if (!allQuestionsAnswered) {
        addNotification("Ошибка", "Пожалуйста, ответьте на все вопросы перед отправкой.", "Danger");
        return;
    }

    $.ajax({
        url: "./src/Api/v1.php?validateTest",
        type: "POST",
        data: {
            testId: testId,
            answers: JSON.stringify(answers)
        },
        success: function(response) {
            if (response.status === "success") {
                addNotification("Успех", 'Результаты теста сохранены успешно!', "Success");
            } else {
                addNotification("Ошибка", 'Ошибка при сохранении результатов теста: ' + response.message, "Danger");

            }
        },
        error: function() {
            addNotification("Ошибка", "Произошла ошибка при отправке данных на сервер.", "Danger");
        }
    });
}



function loadMaterials() {
    $.ajax({
        type: "GET",
        url: "./src/Api/v1.php?getAllContexts",
        success: function(data) {
            let materials = data;
            let materialSelect = $('.material-select');
            materialSelect.empty();

            materials.forEach(function(material) {
                materialSelect.append(`<option value="${material.id}">${material.material_name}</option>`);
            });
        },
        error: function() {
            addNotification("Ошибка", "Не удалось загрузить материалы", "Danger");
        }
    });
}

function renderTestBlock(testQuestions, testDate, testData) {
    let currentTime = testDate;
    let testId = JSON.parse(testData.id);
    let testContent = '<div class="flex items-start gap-2.5 mb-6">';
    testContent += '<img class="w-8 h-8 rounded-full" src="./public/img/expert-logo.png" alt="Expert image">';
    testContent += `<div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 rounded-e-xl rounded-es-xl bg-white last-test">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-semibold text-gray-900">Эксперт GeekBrains</span>
                            <span class="text-sm font-normal text-gray-500">${currentTime}</span>
                        </div>`;

    testQuestions.forEach((question, index) => {
        testContent += `<p class="text-sm font-medium py-2.5 text-gray-900">${question.question}</p>
                        <div class="grid justify-start gap-y-1">`;

        for (let i = 1; i <= 4; i++) {
            let answer = question['answer' + i];
            testContent += `<div class="flex items-center">
                                <input id="answer${i}-q${index+1}" name="answer-q${index+1}" answer-id="${i}" question-id="${index+1}" type="radio" class="border-gray-300 text-purple-600 focus:ring-purple-600">
                                <label for="answer${i}-q${index+1}" class="ml-3 block text-xs font-normal leading-6 text-gray-900">${answer}</label>
                            </div>`;
        }

        testContent += '</div>';
    });

    testContent += `
    <button type="button" class="mt-4 h-[40px] py-[10px] px-[16px] text-[14px] font-medium bg-[#8d46f640] hover:opacity-80 text-center rounded-[4px] font-onest text-[#9655f6] transition-all disabled:opacity-70 disabled:cursor-not-allowed validate-test-button" test-id=${testId} onclick="validateTest(this.getAttribute('test-id'))">Проверить</button>
    </div></div>
    `;
    return testContent;
}



function renderChat(data) {
    let chatBlock = $('.chat-block');
    chatBlock.empty();

    data.forEach(message => {
        if (message.messageType === "bot_test") {
            const testData = JSON.parse(message.answerText);
            const testDate = message.messageDate;
            const testQuestions = JSON.parse(testData.test_json);
            chatBlock.append(renderTestBlock(testQuestions, testDate, testData));
        } else if (message.senderType === "bot") {
            chatBlock.append(`
                <div class="flex items-start gap-2.5 mb-6">
                    <img class="w-8 h-8 rounded-full" src="./public/img/expert-logo.png" alt="Expert image">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 rounded-e-xl rounded-es-xl bg-white">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-semibold text-gray-900">Эксперт GeekBrains</span>
                            <span class="text-sm font-normal text-gray-500">${message.messageDate}</span>
                        </div>
                        <p class="text-sm font-normal py-2.5 text-gray-900">${message.answerText}</p>
                    </div>
                </div>
            `);
        } else {
            chatBlock.append(`
                <div class="flex items-start justify-end gap-2.5 mb-6">
                    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 rounded-s-xl rounded-ee-xl bg-white">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-semibold text-gray-900">Вы</span>
                            <span class="text-sm font-normal text-gray-500">${message.messageDate}</span>
                        </div>
                        <p class="text-sm font-normal py-2.5 text-gray-900">${message.answerText}</p>
                    </div>
                    <img class="w-8 h-8 rounded-full" src="./public/img/user-logo.png" alt="User image">
                </div>
            `);
        }
    });

    scrollToBottom();

}

function checkAndToggleInput(data) {
    if (data.length > 0 && data[data.length - 1].senderType === "user") {
        $('.message-input, .send-new-message-button').prop('disabled', true);
    } else {
        $('.message-input, .send-new-message-button').prop('disabled', false);
    }
}

function scrollToBottom() {
    let chatBlock = $('.chat-block');
    chatBlock.scrollTop(chatBlock.prop("scrollHeight"));
}