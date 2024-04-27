# Виртуальный асессор

## О проекте
"Виртуальный асессор" - это комплексное решение, основанное на онлайн платформе с использованием чат-бота и нейросетей для поддержки обучения. Платформа предлагает:
- Извлечение информации из текстов и изображений
- Поддержка в ответах на вопросы
- Интерактивное тестирование для оценки знаний студентов

## Минимальные требования сервера для Frontend+Backend
- CPU: 2 ядра
- ОЗУ: 2 ГБ
- SSD/HDD: 20 ГБ

## Установка
### Зависимости сервера
Установка производится на любом Linux сервере. В качестве примера рассмотрим установку на Ubuntu 20.04.

#### Обновление системы
```bash
sudo apt update
sudo apt upgrade -y
```

#### Установка Nginx
```bash
sudo apt install nginx -y
```

#### Установка PHP и расширений
```bash
Установка PHP и расширений
```

#### Установка MySQL
```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
```

#### Дополнительные шаги для настройки PHP
```bash
sudo systemctl start php7.4-fpm
sudo systemctl enable php7.4-fpm
```

#### Настройка Nginx для работы с PHP
Создайте или отредактируйте конфигурационный файл в /etc/nginx/sites-available/your_domain с следующим содержимым:
```nginx
server {
    listen 80;
    server_name your_domain.com www.your_domain.com;

    root /var/www/your_domain;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}

```

#### Перезапуск Nginx

```bash
sudo nginx -t
sudo systemctl restart nginx
```
### Установка Frontend + Backend
1. Скачайте контент из папок `web` и `database`.
2. Переместите контент папки `web` в корень вашего сайта.
3. Создайте новую базу данных и импортируйте в неё дамп из папки `database`.
4. Откройте файл `src/Custom/Medoo/connect.php` и укажите параметры подключения к базе данных:
    ```
    $pdo = new PDO('mysql:dbname=DB_NAME;host=localhost', 'DB_USR', 'DB_PWD');
    ```
5. Откройте файл `src/Api/v1.php` и укажите URL вашего Post-Backend API:
    ```
    $apiUrl = "YOUR_URL_HERE";
    ```

## Запуск
После установки и настройки всех компонентов, откройте сайт из корня сервера для доступа к авторизации и начала работы с платформой. Стандартные данные для учетной записи администратора: `admin:admin`

# Установка Post-Backend части (Model)

Saiga LLaMa 3
Минимальные требования от сервера для модели:
- 24 GB VRAM
- 38 GB RAM
- SSD/HDD 20 GB (свободное место)

Saiga-Mistral
Минимальные требования от сервера для модели:
- 20 GB VRAM
- 24GB RAM 
- SSD/HDD 20 GB (свободное место)

OCR model
- 4 GB RAM


**Версия Python на тестах 3.9**

### Процесс установки для Windows RDP:
1. Скачайте контент папки llm_back
2. Переместите контент папки llm_back в удобное для вас место и инициализируйте venv
3. Установите зависимости через команду:
```python
  pip install -r requirements.txt
```

Архитектура: 
```text

llm_back│               
│
├── document_loaders.py             - Файл модуля Python, отвечающий за обработку документов, например, загрузка, парсинг документов DOCX.
│
├── llm_part.py                     - Файл модуля Python, где описана логика работы с Large Language Models (LLM).
│
├── main.py                         - Основной файл FastAPI, который запускает сервер и содержит определение маршрутов API, обработку запросов и возвращение ответов.
│
├── ocr.py                          - Файл модуля Python, предназначенный для работы с easyOCR, который может обрабатывать изображения и извлекать из них текст.
│
├── prompts.py                      - Файл модуля Python, где хранятся различные шаблоны промптов, которые использованы при взаимодействии с LLM.
│
└── req.py                          - Файл модуля Python, в котором содержатся функции для выполнения HTTP-запросов средствами библиотеки requests.


```
### Редактирование конфига
В req.py заменить `url_s = "http://127.0.0.1/src/Api/v1.php"` на ссылку к вашему Api backend 

### Для запуска требуется прописать в консоли:
```python
uvicorn main:app --reload --host server --port 8080
```
###
4. Переходим на http://127.0.0.1:8080/docs Тут у нас лежат эндпоинты к основным функциям.



