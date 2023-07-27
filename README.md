Деплой:
1. Подключаемся к серверу по SSH
2. Устанавливаем composer (если не установлен), а так же обновляем php до версии 8.2
3. Клонируем репозиторий на хостинг в папку
4. Выполняем команду composer install (composer версия 2. и выше)
5. Редактируем файл .env:
   Изменяем поле: APP_URL, вместо http://localhost пишем свой домен https://example.com
   Изменяем настройки доступа к БД:
       DB_CONNECTION=mysql (пишем сюда свою СУБД)
       DB_HOST=localhost (пишем хост БД)
       DB_PORT=3306 (порт по умолчанию)
       DB_DATABASE=DB_NAME (название базы данных)
       DB_USERNAME=USERNAME (логин от доступа к БД)
       DB_PASSWORD=PASSWORD (пароль от доступа к БД)
6. Сохраняем файл .env
7. Создаём символическую ссылку (на разных хостинга по разному это делается)
   Пример Beget: ln -s yourdir/public public_html (предварительно удаяем папку publick_html)
   Пример IPSMangager: ln -s yourdir/public/index.php index.php (Предварительно удаляем файл index.html/index.php)
