<?php

include_once __DIR__ . '/../Custom/Medoo/connect.php';
include_once __DIR__ . '/../Functions/utility.class.php';

@session_start();

$utilityClass = new UtilityClass();

// https://server:8080
$apiUrl = "YOUR_URL_HERE";

$welcomeMessages = [
    "Приветствую, я твой эксперт на сегодня! Сейчас я подумаю над вопросами и вернусь к тебе! 🤓",
    "Здравствуй! Я буду твоим экспертом сегодня. Дай мне немного времени, чтобы подготовить вопросы. 📚",
    "Привет! Я эксперт, который будет помогать тебе сегодня. Скоро вернусь с вопросами. 🧐",
    "Добро пожаловать! Я твой сегодняшний эксперт. Подожди немного, я готовлю для тебя вопросы. 🌟",
    "Привет! Сегодня я твой помощник. Позволь мне немного времени, чтобы организовать наши вопросы. 🕒"
];

$introductoryPhrases = [
    "И так, вопрос следующий: 🤔",
    "Давай подумаем над этим. 🧠",
    "Перейдем к интересующему нас вопросу: 👉",
    "Хорошо, теперь рассмотрим следующее: ➡️",
    "Следующий вопрос для тебя: 📝",
    "Теперь давай обсудим следующее: 🗣️",
    "Интересно твое мнение по следующему вопросу: 💬",
    "Давай перейдем к следующему пункту: 🔜",
    "Теперь вот что меня интересует: 🕵️‍♂️",
    "И вот следующий вопрос, который я хотел бы задать: ❓"
];

$successPhrases = [
    "Отлично. Идем дальше! 👍",
    "Хорошо, давай следующий вопрос. 🏃‍♂️",
    "Прекрасно, продолжим! 🚀",
    "Отличная работа, переходим к следующему пункту. 👏",
    "Замечательно, что еще у нас есть? 🤗",
    "Великолепно, следующий вопрос пожалуйста. 🎯",
    "Хорошо справляешься, давай дальше. 🌟",
    "Это было легко! Переходим к следующему вызову. 💪",
    "И так, следующий шаг! 🛤️"
];

$leadingPhrases = [
    "Так, чего то не хватает. 🧐",
    "Вроде бы что то не совсем так. 🤨",
    "Кажется, мы упустили важный момент. 🕵️‍♀️",
    "Подожди, это не совсем то, что нужно. ⚠️",
    "Может быть, стоит пересмотреть этот ответ? 🔄",
    "Что-то здесь не так, давай попробуем еще раз. 🔁",
    "Это почти правильно, но давай уточним детали. 🔍"
];

$wrongPhrases = [
    "Ладно, пойдем дальше. 🚶‍♂️",
    "Давай пропустим это. Следующий вопрос. ➡️",
    "Это не совсем то, но ладно. 🤷‍♂️",
    "Не страшно, перейдем к другому вопросу. 🤔",
    "Ну, не получилось. Зато впереди новый вопрос! 🎢",
    "Ошибки случаются, давай лучше следующий вопрос. 🙃",
    "Это было сложно, попробуем что-то другое. 😓"
];

$excellentPhrases = [
    "Отличная работа! Все правильно. 🌟",
    "Прекрасно справились! 👏",
    "Вы настоящий эксперт! 🥇"
];

$goodPhrases = [
    "Хороший результат, но есть куда стремиться! ✨",
    "Неплохо! Но вы можете лучше. 💪"
];

$averagePhrases = [
    "Средний результат. Вы неплохо справились. 👍",
    "Есть ошибки, но вы на правильном пути! 🚧"
];

$poorPhrases = [
    "Похоже, нужно немного подтянуть знания. 📚",
    "Не сдавайтесь и учитесь вместе с нами! У вас все получится! 💖"
];

if(isset($_GET['authUser'])) {

    if(!empty($_POST['login']) && !empty($_POST['password'])) {

        $login = $utilityClass->sanitizeParam($_POST['login']);
        $password = $utilityClass->sanitizeParam($_POST['password']);
    
        $databaseCallback = $database->get("gb_users", ["id", "login", "role"], ["login" => $login, "password" => md5($password)]);
    
        if (empty($databaseCallback['id'])) {
            $utilityClass->addJavaScript('addNotification("Ошибка авторизации", "Введенные данные неверны. Повторите попытку!", "Danger")');
            exit();
        }
    
        $_SESSION['id'] = $databaseCallback['id'];
        $_SESSION['login'] = $login;
        $_SESSION['role'] = $databaseCallback['role'];
    
        exit($utilityClass->changeLocationViaHTML('0', './dashboard'));

    }

}

if(isset($_GET["getChatHistory"])) {
    $utilityClass->checkSessions("dashboardAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    $databaseCallback = $database->select("gb_chat", ["id", "sender_type", "answer_text", "message_type", "message_date"], [
        "ORDER" => [
            "id" => "ASC"
        ], 
        "user_id" => $utilityClass->id()
    ]);
    

    foreach ($databaseCallback as $databaseQuery) {
        $output[] = [
            'identity' => $databaseQuery['id'],
            'senderType' => $databaseQuery['sender_type'],
            'answerText' => $databaseQuery['answer_text'],
            'messageType' => $databaseQuery['message_type'],
            'messageDate' => $databaseQuery['message_date']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($output);

}

//! ДОБАВИТЬ ТЕСТ ИЛИ СТАТИСТИКУ
if(isset($_GET["sendUserMessage"])) {
    $utilityClass->checkSessions("dashboardAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    if(empty($_POST["answerText"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid answer"]));
    }

    $answerText = $utilityClass->sanitizeParam($_POST["answerText"]);

    $questionIds = $database->select("gb_chat", ["id", "question_id"], [
        "user_id" => $utilityClass->id(),
        "sender_type" => "bot",
        "question_id[!]" => 0,
        "ORDER" => ["id" => "DESC"]
    ]);

    if (!empty($questionIds)) {
        $lastId = $questionIds[0]['question_id'];
    } else {
        $lastId = 0;
    }

    if($answerText == "Тест") {
        $materialId = $database->get("gb_questions", ["material_id"], [
            "id" => $lastId
        ]);

        $testJson = $database->get("gb_tests", ["id", "test_json"], [
            "material_id" => $materialId
        ]);

        $databaseInsertTest = $database->insert('gb_chat', [
            'user_id' => (string) $userId,
            'sender_type' => "bot",
            'question_id' => "0",
            'answer_text' => json_encode($testJson, true),
            'message_type' => "bot_test",
            'message_date' => $utilityClass->getCurrentDateTime()
        ]);

        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "message" => "Test successfully generated!"]);
        exit();
    } else if($answerText == "Статистика") {
        $totalMetrics = $database->sum("gb_metrics", "metrics", [
            "user_id" => (string) $userId
        ]);
        
        $countMetrics = $database->count("gb_metrics", [
            "user_id" => (string) $userId
        ]);

        $databaseInsertTest = $database->insert('gb_chat', [
            'user_id' => (string) $userId,
            'sender_type' => "bot",
            'question_id' => "0",
            'answer_text' => "Отлично! Ваша статистика равна - $totalMetrics к $countMetrics. Чем ближе первое число ко второму, тем вы более круто усвоили материал! 🌟",
            'message_type' => "bot_message",
            'message_date' => $utilityClass->getCurrentDateTime()
        ]);

        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "message" => "Statistics successfully generated!"]);
        exit();
    } else if($answerText == "Резюме моих ответов") {
        $allMessages = $database->select("gb_chat", ["sender_type", "answer_text"], [
            "user_id" => $userId,
            "message_type[!]" => "bot_test"
        ]);

        $messageString = "";
        foreach ($allMessages as $message) {
            $messageString .= $message['sender_type'] . ": " . $message['answer_text'] . "; ";
        }

        $messageString = rtrim($messageString, "; ");

        //! send request to the external API
        $utilityClass->sendDataToExternalServer($apiUrl . "/request-resume", [
            "userId" => $userId,
            "chatHistory" => $messageString
        ]);

    }

    $databaseCallback = $database->insert('gb_chat', [
        'user_id' => $userId,
        'sender_type' => "user",
        'question_id' => $lastId,
        'answer_text' => $answerText,
        'message_type' => "user_answer",
        'message_date' => $utilityClass->getCurrentDateTime()
    ]);

    $idealData = $database->get("gb_questions", ["question", "answer"], [
        "id" => $lastId
    ]);

    //! send request to the external API
    $utilityClass->sendDataToExternalServer($apiUrl . "/user-answer", [
        "user_id" => $userId,
        "question_id" => $lastId,
        "answer_text" => $answerText,
        "ideal_answer" => $idealData["answer"],
        "question" => $idealData["question"]
    ]);

    if($database->id()) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "message" => "Successfully sent to the postbackend"]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(["status" => "message", "message" => "Something wrong with your answer..."]);
    }

}

if(isset($_GET["getAllContexts"])) {
    $utilityClass->checkSessions("dashboardAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    $questionIds = $database->select("gb_material", ["id", "material_name"], [
        "ORDER" => [
            "id" => "ASC"
        ],
    ]);

    header('Content-Type: application/json');
    echo json_encode($questionIds);

}

if(isset($_GET["changeChatContext"])) {
    $utilityClass->checkSessions("dashboardAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    if(empty($_POST["materialId"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid material ID"]));
    }

    $materialId = $utilityClass->sanitizeParam($_POST["materialId"]);

    $questionIds = $database->select("gb_questions", ["id", "question"], [
        "material_id" => $materialId
    ]);

    $randomQuestionId = $questionIds[array_rand($questionIds)];

    $welcomeText = $welcomeMessages[array_rand($welcomeMessages)];

    $databaseInsertStarter = $database->insert('gb_chat', [
        'user_id' => (string) $userId,
        'sender_type' => "bot",
        'question_id' => "0",
        'answer_text' => $welcomeText,
        'message_type' => "bot_startmessage",
        'message_date' => $utilityClass->getCurrentDateTime()
    ]);

    //! HARDCODE
    sleep(1);

    $helpText = 'Если ты захочешь перейти к автоматическому тестированию, то просто напиши мне "Тест". Так же, я могу составить статистику по сообщению "Статистика", либо проанализировать все твои ответы по команде "Резюме моих ответов". Я всегда рад тебе помочь! 💖';

    $databaseInsertStarter = $database->insert('gb_chat', [
        'user_id' => (string) $userId,
        'sender_type' => "bot",
        'question_id' => "0",
        'answer_text' => $helpText,
        'message_type' => "bot_message",
        'message_date' => $utilityClass->getCurrentDateTime()
    ]);

    //! HARDCODE
    sleep(1);

    $introductoryText = $introductoryPhrases[array_rand($introductoryPhrases)] . " " . $randomQuestionId['question'];

    $databaseInsertStarterQuestion = $database->insert('gb_chat', [
        'user_id' => (string) $userId,
        'sender_type' => "bot",
        'question_id' => $randomQuestionId['id'],
        'answer_text' => $introductoryText,
        'message_type' => "bot_question",
        'message_date' => $utilityClass->getCurrentDateTime()
    ]);

    if($database->id()) {
        header('Content-Type: application/json');
        echo json_encode(json_encode(["status" => "success", "message" => "The context of the conversation is successfully switched"]));
    } else {
        header('Content-Type: application/json');
        echo json_encode(json_encode(["status" => "message", "message" => "Something wrong with context..."]));
    }

}

if(isset($_GET['saveNewPassword'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);

    $oldPassword = $utilityClass->sanitizeParam($_POST['oldPassword']);
    $newPassword = $utilityClass->sanitizeParam($_POST['newPassword']);

    $databasePassword = $database->get("gb_users", "password", ["id" => $_SESSION["id"]]);

    if($databasePassword != md5($oldPassword)) {
        $utilityClass->addJavaScript('addNotification("Ошибка сохранения", "Старый пароль не совпадает с введенным, повторите попытку!", "Danger")');
        exit();
    }

    $databaseCallback = $database->update("gb_users", [
        "password" => md5($newPassword)
    ], ["id" => $_SESSION["id"]]);

    $response = [
        "response" => "success"
    ];

    echo json_encode($response);
  
}

if(isset($_GET['getAllUsers'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $databaseCallback = $database->select("gb_users", ["id", "login", "role"], ["ORDER" => [
        "id" => "DESC",
    ]]);

    foreach ($databaseCallback as $databaseQuery) {
        $output[] = [
            'identity' => (string) $databaseQuery['id'],
            'login' => $databaseQuery['login'],
            'role' => $databaseQuery['role'],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($output);
    
}

if(isset($_GET['deleteUser'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $userId = $utilityClass->sanitizeParam($_POST['userId']);

    $databaseLogin = $database->delete("gb_users", ["id" => $userId]);

    $response = [
        "response" => "success"
    ];

    echo json_encode($response);
  
}

if(isset($_GET['createNewUser'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $login = $utilityClass->sanitizeParam($_POST['login']);
    $role = $utilityClass->sanitizeParam($_POST['role']);
    $password = $utilityClass->sanitizeParam($_POST['password']);

    $databaseLogin = $database->has("gb_users", ["login" => $login]);

    if($databaseLogin) {
        $utilityClass->addJavaScript('addNotification("Ошибка регистрации", "Пользователь с таким логином уже существует!", "Danger")');
        exit();
    }

    $databaseCallback = $database->insert("gb_users", [
        "login" => $login,
        "password" => md5($password),
        "role" => $role
    ]);

    $response = [
        "response" => "success"
    ];

    echo json_encode($response);
  
}

if(isset($_GET['uploadNewMaterial'])) {
    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0 && !empty($_POST['materialName'])) {
        $materialName = $utilityClass->sanitizeParam($_POST['materialName']);
        $originalName = $_FILES['file']['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        
        if($extension !== "docx") {
            echo json_encode(["status" => "error", "message" => "Invalid file type"]);
            exit();
        }

        $randomName = rand(1000000000, 9999999999) . "." . $extension;
        $filePath = __DIR__ . "/../../temp/" . $randomName;

        if(move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $databaseCallback = $database->insert("gb_material", [
                "material_name" => $materialName,
                "filename" => $randomName,
                "upload_date" => $utilityClass->getCurrentDateTime()
            ]);

            if($database->id()) {
                echo json_encode(["status" => "success", "message" => "Material successfully uploaded"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "File or material name is missing"]);
    }
}

if(isset($_GET['getAllMaterial'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $databaseCallback = $database->select("gb_material", ["id", "material_name", "upload_date"], ["ORDER" => [
        "id" => "DESC",
    ]]);

    foreach ($databaseCallback as $databaseQuery) {
        $output[] = [
            'identity' => (string) $databaseQuery['id'],
            'materialName' => $databaseQuery['material_name'],
            'uploadDate' => $databaseQuery['upload_date'],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($output);
    
}

if(isset($_GET['getSpecificMaterialData'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    if(empty($_POST["materialId"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid material ID"]));
    }

    $materialId = $utilityClass->sanitizeParam($_POST["materialId"]);

    $questionsArray = $database->select("gb_questions", ["id", "question", "answer"], [
        "material_id" => $materialId
    ]);

    $testJson = $database->get("gb_tests", ["test_json"], [
        "material_id" => $materialId
    ]);

    $materialData = $database->get("gb_material", ["material_name", "upload_date"], [
        "id" => $materialId
    ]);

    $output = [
        "status" => "success",
        "material" => [
            "identity" => $materialId,
            "materialName" => $materialData['material_name'],
            "uploadDate" => $materialData['upload_date'],
            "questions" => $questionsArray ?? null,
            "testJson" => $testJson['test_json'] ?? null
        ]
    ];

    header('Content-Type: application/json');
    echo json_encode($output);
}



if (isset($_GET["receiveBotAnswer"])) {
    $requiredFields = ['answerText', 'questionId', 'userId'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field]) || !is_numeric($_POST['metrics'])) {
            exit(json_encode(["status" => "error", "message" => "Invalid request body"]));
        }
    }

    $answerText = $utilityClass->sanitizeParam($_POST["answerText"]);
    $questionId = $utilityClass->sanitizeParam($_POST["questionId"]);
    $userId = $utilityClass->sanitizeParam($_POST["userId"]);
    $metrics = (int) $utilityClass->sanitizeParam($_POST["metrics"]);

    $database->insert("gb_metrics", [
        'user_id' => $userId,
        'question_id' => $questionId,
        'metrics' => $metrics
    ]);

    $materialId = $database->get("gb_questions", "material_id", ["id" => $questionId]);
    $alreadyAnsweredIds = array_column($database->select("gb_chat", ["question_id"], [
        "user_id" => $userId,
        "message_type" => "bot_question"
    ]), 'question_id');
    
    $questionIds = $database->select("gb_questions", ["id", "question"], [
        "material_id" => $materialId,
        "id[!]" => $alreadyAnsweredIds
    ]);

    $endInteraction = function () use ($database, $userId, $utilityClass) {
        $database->insert('gb_chat', [
            'user_id' => $userId,
            'sender_type' => "bot",
            'question_id' => "0",
            'answer_text' => 'Окей, кажется, вопросы кончились. Можем попробовать пройти тест по материалу, либо ты можешь посмотреть свою статистику! Напиши "Тест" или "Статистика" или "Резюме моих ответов"',
            'message_type' => "bot_message",
            'message_date' => $utilityClass->getCurrentDateTime()
        ]);
    };    

    if ($metrics === 1) {
        if (!empty($questionIds)) {
            $randomQuestion = $questionIds[array_rand($questionIds)];
            $questionId = $randomQuestion['id'];
            $successText = $successPhrases[array_rand($successPhrases)] . " " . $randomQuestion['question'];
            $database->insert('gb_chat', [
                'user_id' => $userId,
                'sender_type' => "bot",
                'question_id' => $questionId,
                'answer_text' => $successText,
                'message_type' => "bot_question",
                'message_date' => $utilityClass->getCurrentDateTime()
            ]);
        } else {
            $endInteraction();
        }
    } else if ($metrics === 0) {
        $countAnswerTries = $database->count("gb_metrics", [
            "user_id" => $userId,
            'question_id' => $questionId,
            "metrics" => "0"
        ]);

        if ($countAnswerTries <= 3) {
            $leadingText = $leadingPhrases[array_rand($leadingPhrases)] . " " . $answerText;
            $database->insert('gb_chat', [
                'user_id' => $userId,
                'sender_type' => "bot",
                'question_id' => $questionId,
                'answer_text' => $leadingText,
                'message_type' => "bot_leading_question",
                'message_date' => $utilityClass->getCurrentDateTime()
            ]);
        } else {
            if (!empty($questionIds)) {
                $randomQuestion = $questionIds[array_rand($questionIds)];
                $questionId = $randomQuestion['id'];
                $wrongText = $wrongPhrases[array_rand($wrongPhrases)] . " " . $randomQuestion['question'];
                $database->insert('gb_chat', [
                    'user_id' => $userId,
                    'sender_type' => "bot",
                    'question_id' => $questionId,
                    'answer_text' => $wrongText,
                    'message_type' => "bot_question",
                    'message_date' => $utilityClass->getCurrentDateTime()
                ]);
            } else {
                $endInteraction();
            }
        }
    }
}


if(isset($_GET['createQuestions'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    if(empty($_POST["materialId"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid material ID"]));
    }

    $materialId = $utilityClass->sanitizeParam($_POST["materialId"]);

    $databaseDelete = $database->delete("gb_questions", [
        "material_id" => $materialId
    ]);

    $databaseCallback = $database->get("gb_material", ["filename"], [
        "id" => $materialId
    ]);

    $fileUrl = $utilityClass->getFullServerUrl() . "/temp/" . $databaseCallback["filename"];

    //! send request to the external API
    $data = $utilityClass->sendDataToExternalServer($apiUrl . "/create-questions", [
        "fileUrl" => $fileUrl,
        "materialId" => $materialId
    ]);

    header('Content-Type: application/json');
    echo json_encode(json_encode(["status" => "success", "message" => "Request successfully sent"]));
    
}

if (isset($_GET['receiveQuestions'])) {
    if (empty($_POST["questionsJson"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid questions json"]));
    }

    $questionsJson = $_POST["questionsJson"];
    $questionsData = json_decode($questionsJson, true);

    if (json_last_error() !== JSON_ERROR_NONE || !isset($questionsData['data'])) {
        exit(json_encode(["status" => "error", "message" => "Invalid JSON format"]));
    }

    foreach ($questionsData['data'] as $item) {
        if (!isset($item['question'], $item['answer'], $item['materialId'])) {
            continue;
        }

        if(strlen($item['question']) > 4 && strlen($item['answer']) > 4) {
            $database->insert("gb_questions", [
                "question" => $item['question'],
                "answer" => $item['answer'],
                "material_id" => $item['materialId']
            ]);
        }
        
    }

    if($database->id()) {
        echo json_encode(["status" => "success", "message" => "Questions successfully received"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error with inserting"]);
    }
    
}

if(isset($_GET['createTest'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    if(empty($_POST["materialId"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid material ID"]));
    }

    $materialId = $utilityClass->sanitizeParam($_POST["materialId"]);

    $databaseDelete = $database->delete("gb_tests", [
        "material_id" => $materialId
    ]);

    $databaseCallback = $database->get("gb_material", ["filename"], [
        "id" => $materialId
    ]);

    $fileUrl = $utilityClass->getFullServerUrl() . "/temp/" . $databaseCallback["filename"];

    //! send request to the external API
    $data = $utilityClass->sendDataToExternalServer($apiUrl . "/create-test", [
        "fileUrl" => $fileUrl,
        "materialId" => $materialId
    ]);

    header('Content-Type: application/json');
    echo json_encode(json_encode(["status" => "success", "message" => "Request successfully sent"]));
    
}

if (isset($_GET['receiveTest'])) {
    if (empty($_POST["testJson"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid test json"]));
    }

    $testJson = json_decode($_POST["testJson"], true);

    if (!isset($testJson["data"]) || empty($testJson["materialId"])) {
        exit(json_encode(["status" => "error", "message" => "Missing required data or material ID"]));
    }

    $testData = json_encode($testJson["data"]);

    $insertResult = $database->insert("gb_tests", [
        "test_json" => $testData,
        "material_id" => $testJson['materialId']
    ]);

    if ($insertResult->rowCount()) {
        echo json_encode(["status" => "success", "message" => "Questions successfully received"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error with inserting"]);
    }
    
}

if (isset($_GET['deleteSpecificQuestion'])) {
    if (empty($_POST["questionId"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid question id"]));
    }

    $questionId = $_POST["questionId"];

    $data = $database->delete("gb_questions", [
        "id" => $questionId
    ]);

    if($data->rowCount()) {
        echo json_encode(["status" => "success", "message" => "Question successfully deleted"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error with deleting"]);
    }
    
}

if (isset($_GET['validateTest'])) {

    $utilityClass->checkSessions("dashboardAccess", $database);
    $utilityClass->checkSessions("adminAccess", $database);

    $userId = $utilityClass->id();

    if(empty($userId)) {
        exit(json_encode(["status" => "error", "message" => "Access Denied"]));
    }

    if (empty($_POST["testId"]) || empty($_POST["answers"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid test id or answers"]));
    }

    $testId = $utilityClass->sanitizeParam($_POST["testId"]);
    $answers = $utilityClass->sanitizeParam($_POST["answers"]);

    $testJson = $database->get("gb_tests", "test_json", [
        "id" => $testId
    ]);

    $testData = json_decode($testJson, true);

    $userAnswers = json_decode(html_entity_decode($answers), true);

    $totalQuestions = count($testData);
    $correctAnswers = 0;

    foreach ($userAnswers as $userAnswer) {
        $questionIndex = $userAnswer['questionId'] - 1;
        $answerIndex = $userAnswer['answerId']; 

        if ($testData[$questionIndex]['right'] == $answerIndex) {
            $correctAnswers++;
        }
    }

    $percentageCorrect = ($correctAnswers / $totalQuestions) * 100;

    if ($percentageCorrect == 100) {
        $selectedPhrase = $excellentPhrases[array_rand($excellentPhrases)];
    } elseif ($percentageCorrect >= 75) {
        $selectedPhrase = $goodPhrases[array_rand($goodPhrases)];
    } elseif ($percentageCorrect >= 50) {
        $selectedPhrase = $averagePhrases[array_rand($averagePhrases)];
    } else {
        $selectedPhrase = $poorPhrases[array_rand($poorPhrases)];
    }

    $testText = $selectedPhrase . " Вы ответили правильно на $correctAnswers из $totalQuestions вопросов.";

    $database->insert('gb_metrics', [
        'user_id' => $userId,
        'question_id' => 0,
        'metrics' => ceil($correctAnswers / 2)
    ]);

    $database->insert('gb_chat', [
        'user_id' => $userId,
        'sender_type' => "bot",
        'question_id' => 0,
        'answer_text' => $testText,
        'message_type' => "bot_message",
        'message_date' => $utilityClass->getCurrentDateTime()
    ]);

    if($database->id()) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "message" => "Test results sent successfully"]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Somethings wrong with adding it to the database"]);
    }
    
}

if (isset($_GET['receiveResume'])) {
    if (empty($_POST["resume"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid resume"]));
    }

    if (empty($_POST["userId"])) {
        exit(json_encode(["status" => "error", "message" => "Invalid userid"]));
    }

    $resume = $utilityClass->sanitizeParam($_POST["resume"]);
    $userId = $utilityClass->sanitizeParam($_POST["userId"]);

    $insertResult = $database->insert('gb_chat', [
        'user_id' => $userId,
        'sender_type' => "bot",
        'question_id' => "0",
        'answer_text' => $resume,
        'message_type' => "bot_message",
        'message_date' => $utilityClass->getCurrentDateTime()
    ]);

    if ($insertResult->rowCount()) {
        echo json_encode(["status" => "success", "message" => "Resume successfully received"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error with inserting"]);
    }
    
}