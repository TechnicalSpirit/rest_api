# Как запустить приложение

Сперва нужно создать контейнеры докера с помощью docker-compose

```bash
docker-compose up -d
```

Дальше нужно будет установить все пакеты для Lumen 

```bash
docker-compose run php composer install
```

Теперь у вас есть все необходимые компоненты, создайте в файл .env. 

Скопируйте в него всё содержание файла .env.example

Нужно будет установить вот такие значения, у переменных в файле .env

```php
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

После этого нужно будет выгрузить все необходимые таблицы в базу данных

```bash
docker-compose run artisan migrate
```

Зайдите на ссылку http://localhost/ 

Если вы увидели: "It’s good that this page appeared, but this application is needed for REST API", то тогда можем переходить к работе с API.

Документация по API:

1) GET /loans — получение списка всех займов с базовыми фильтрами по дате создания и сумме.

2) GET /loans/{id} — получение информации о займе

3) POST /loans — создание нового займа

4) PUT /loans/{id} — обновление информации о займе. 

5) DELETE /loans/{id} — удаление займа

Если решишь протестировать работу кода, то это можно сделать с помощью команды:

```bash
docker-compose run php composer start-test
```

В качестве линтера я использовал php_codesniffer, вот так его можно запустить

```bash
docker-compose run php composer lint-analysis
```