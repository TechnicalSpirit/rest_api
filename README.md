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

## Документация по API:

1) GET /loans — получение списка всех займов с базовыми фильтрами по дате создания и сумме.

Примеры:

- Получить все займы

http://localhost/loans

```json
{
  "loans": [
    {
      "id": 1,
      "amount": "1000.00",
      "duration": 14,
      "interest_rate": "8.80",
      "created_at": "2022-01-01T00:00:00.000000Z",
      "updated_at": "1972-03-23T22:57:17.000000Z"
    },
    {
      "id": 2,
      "amount": "2000.00",
      "duration": 18,
      "interest_rate": "4.57",
      "created_at": "2022-01-02T00:00:00.000000Z",
      "updated_at": "1993-07-14T06:26:52.000000Z"
    },
    ...
  ]
}
```

- Получить все займы, созданные в конкретный день

http://localhost/loans?created_at=2022-01-01

```json
{
  "loans": [
    {
      "id": 1,
      "amount": "1000.00",
      "duration": 14,
      "interest_rate": "8.80",
      "created_at": "2022-01-01T00:00:00.000000Z",
      "updated_at": "1972-03-23T22:57:17.000000Z"
    },
    ...
  ]
}
```

- Получить все займы, созданные с конкретной суммой

http://localhost/loans?amount=1000

```json
{
  "loans": [
    {
      "id": 1,
      "amount": "1000.00",
      "duration": 14,
      "interest_rate": "8.80",
      "created_at": "2022-01-01T00:00:00.000000Z",
      "updated_at": "1972-03-23T22:57:17.000000Z"
    },
    {
      "id": 3,
      "amount": "1000.00",
      "duration": 24,
      "interest_rate": "8.92",
      "created_at": "2022-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-30T01:39:53.000000Z"
    },
    ...
  ]
}
```

2) GET /loans/{id} — получение информации о займе

- Получаем информацию о займе по его id

http://localhost/loans/2

```json
{
  "loan": {
    "id": 2,
    "amount": "2000.00",
    "duration": 18,
    "interest_rate": "4.57",
    "created_at": "2022-01-02T00:00:00.000000Z",
    "updated_at": "1993-07-14T06:26:52.000000Z"
  }
}
```

3) POST /loans — создание нового займа

```bash
curl -X POST http://localhost/loans \
     -d '{"amount": 1000, "duration": 30}'
```

4) PUT /loans/{id} — обновление информации о займе.

```bash
curl -X PUT http://localhost/loans/1 \
     -d '{"amount": 1200, "duration": 45}'
```

5) DELETE /loans/{id} — удаление займа

```bash
curl -X DELETE http://localhost/loans/1
```

#### Доп моменты

Если запись, с которой ты пытаешься провести операцию отсутствует в базе данных,
то ты получишь такой ответ:

```json
{"message":"Not found"}
```

Если на момент создания, или обновления записи ты дашь неверные аргументы,
то ты получишь один из этих вариантов:

- если amount у тебя не число

```json
{"message":"The amount must be a number."}
```

- если duration у тебя не целое число

```json
{"message":"The duration must be an integer."}
```

- если interest_rate у тебя не число

```json
{"message":"The interest rate must be a number."}
```

## Как запустить тесты ?

Если решишь протестировать работу кода, то это можно сделать с помощью команды:
```bash
docker-compose run php composer start-test
```

## Как запустить проверку литом ?

В качестве линтера я использовал php_codesniffer, вот так его можно запустить

```bash
docker-compose run php composer lint-analysis
```