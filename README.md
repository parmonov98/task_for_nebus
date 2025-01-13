# API для поиска организаций

API для управления организациями с возможностью поиска по местоположению.

## Требования

-   PHP 8.2 или выше
-   Composer
-   MySQL 5.7 или выше
-   OpenSSL PHP расширение
-   PDO PHP расширение
-   Mbstring PHP расширение
-   Tokenizer PHP расширение
-   XML PHP расширение

## Установка

1. Клонируем репозиторий:

```bash
git clone <repository-url>
cd task_for_nebus
```

2. Устанавливаем PHP зависимости:

```bash
composer install
```

3. Настройка окружения:

```bash
# Копируем файл окружения
cp .env.example .env

# Генерируем ключ приложения
php artisan key:generate
```

4. Настраиваем файл `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

API будет доступно по адресу `http://localhost:8000`

## Установка через Docker

### Требования

-   Docker
-   Docker Compose

### Быстрый старт

1. Клонируем репозиторий:

```bash
git clone <repository-url>
cd task_for_nebus
```

2. Копируем файл окружения:

```bash
cp .env.example .env
```

3. Запускаем контейнеры:

```bash
docker-compose up -d
```

4. Устанавливаем зависимости и выполняем миграции:

```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

### Доступные сервисы

После запуска будут доступны следующие сервисы:

-   **API**: `http://localhost:8000`
-   **PhpMyAdmin**: `http://localhost:8080`
    -   Сервер: `db`
    -   Пользователь: из .env (DB_USERNAME)
    -   Пароль: из .env (DB_PASSWORD)
-   **Redis**: `localhost:6379`
-   **Redis Commander**: `http://localhost:8081`
-   **Swagger Documentation**: `http://localhost:8000/api/documentation`

### Структура Docker

Проект содержит следующие контейнеры:

-   **app**: PHP 8.2 приложение
-   **nginx**: Веб-сервер
-   **db**: База данных MariaDB
-   **redis**: Redis сервер
-   **phpmyadmin**: Интерфейс управления базой данных
-   **redis-commander**: Интерфейс управления Redis

### Полезные команды

1. Просмотр логов:

```bash
docker-compose logs -f [service_name]
```

2. Перезапуск сервисов:

```bash
docker-compose restart [service_name]
```

3. Остановка контейнеров:

```bash
docker-compose down
```

4. Пересборка контейнеров:

```bash
docker-compose up -d --build
```

5. Доступ к консоли PHP:

```bash
docker-compose exec app bash
```

## API Документация

Полная документация API доступна через Swagger UI: `http://localhost:8000/api/documentation`
