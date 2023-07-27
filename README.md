Деплой:
1. Подключаемся к серверу по SSH
2. Устанавливаем composer (если не установлен), а так же обновляем php до версии 8.2
3. Клонируем репозиторий на хостинг в папку
4. Выполняем команду composer install (composer версия 2. и выше)
5. Редактируем файл .env:
   Изменяем поле: APP_URL, вместо http://localhost пишем свой домен https://example.com <br>
   Изменяем настройки доступа к БД:<br>
       DB_CONNECTION=mysql (пишем сюда свою СУБД)<br>
       DB_HOST=localhost (пишем хост БД)<br>
       DB_PORT=3306 (порт по умолчанию)<br>
       DB_DATABASE=DB_NAME (название базы данных)<br>
       DB_USERNAME=USERNAME (логин от доступа к БД)<br>
       DB_PASSWORD=PASSWORD (пароль от доступа к БД)<br>
6. Сохраняем файл .env 
7. Создаём символическую ссылку (на разных хостинга по разному это делается)<br>
   Пример Beget: ln -s yourdir/public public_html (предварительно удаяем папку publick_html)<br>
   Пример IPSMangager: ln -s yourdir/public/index.php index.php (Предварительно удаляем файл index.html/index.php)

8. Чтобы проект заработал так же необходимо накатить миграции БД, и установить ключ приложения, для этого, так же по ssh заходим в папку в которую склонировали репозиторий и пишем сначала php artisan key:generate после этого php artisan migrate


