# Инструкция по загрузке на 000webhost

## Шаг 1: Регистрация на 000webhost

1. Перейдите на https://www.000webhost.com/
2. Нажмите "Sign Up Free"
3. Зарегистрируйтесь через email или Google

## Шаг 2: Создание сайта

1. После входа нажмите "Create new site"
2. Выберите "Upload your own website"
3. Введите название сайта и домен

## Шаг 3: Загрузка файлов

### Способ 1: Через FileZilla

1. Скачайте FileZilla: https://filezilla-project.org/
2. Получите FTP-данные в панели 000webhost:
   - Хостинг → Settings → FTP account
3. Подключитесь к серверу
4. Загрузите все файлы из папки `apartment-rental/` в папку `public_html`

### Способ 2: Через панель 000webhost

1. В панели управления выберите **File Manager**
2. Откройте папку `public_html`
3. Нажмите **Upload files**
4. Загрузите все файлы проекта

## Шаг 4: Настройка базы данных

1. В панели 000webhost выберите **MySQL**
2. Создайте новую базу данных:
   - Имя базы данных
   - Имя пользователя
   - Пароль
3. Запомните эти данные

## Шаг 5: Настройка .env

1. В File Manager отредактируйте файл `.env`
2. Измените настройки базы данных:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ваше_имя_бд
DB_USERNAME=ваш_пользователь
DB_PASSWORD=ваш_пароль
```

## Шаг 6: Запуск миграций

1. В панели 000webhost выберите **Terminal** (если доступно)
2. Или создайте файл `migrate.php` в public_html:

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Illuminate\Support\Facades\Schema::dropAllTables();
Artisan::call('migrate', ['--force' => true]);
echo 'Migration complete!';
```

3. Откройте в браузере: `ваш-сайт.ru/migrate.php`

## Шаг 7: Запуск сидов

Аналогично миграциям, создайте `seed.php`:

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Artisan::call('db:seed', ['--force' => true]);
echo 'Seeding complete!';
```

## Шаг 8: Проверка

1. Откройте ваш домен
2. Сайт должен работать!

## Тестовые аккаунты

После `db:seed`:
- **Пользователь**: ivan@example.com / password123
- **Агент**: maria@example.com / password123

## Альтернативные хостинги

Если 000webhost не работает, попробуйте:
- **Heroku** (бесплатно, но сложнее)
- **OpenServer** (для локальной разработки)
- **Beget** (платный, но российский)

## Поддержка

При проблемах:
1. Проверьте PHP версию (нужен 8.1+)
2. Проверьте права на файлы
3. Проверьте настройки .env
4. Проверьте логи ошибок в панели хостинга