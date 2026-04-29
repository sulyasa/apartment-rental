# 🚀 Деплой на Railway

## Шаг 1: Регистрация

1. Перейдите на https://railway.com/
2. Нажмите **"Start Deploying"**
3. Войдите через **GitHub** (выберите `sulyasa/apartment-rental`)

## Шаг 2: Создание проекта

1. Нажмите **"New Project"**
2. Выберите **"Deploy from GitHub repo"**
3. Найдите репозиторий `apartment-rental`
4. Нажмите **"Deploy"**

## Шаг 3: Настройка переменных

В панели Railway перейдите в **"Variables"** и добавьте:

```
APP_NAME=ApartmentRental
APP_ENV=production
APP_KEY=base64:генерируйте_свой_ключ_через_artisan_key_generate
APP_DEBUG=false
APP_URL=https://ваш-проект.railway.app

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=пароль_из_переменных
```

## Шаг 4: Настройка базы данных

1. Перейдите в **"Services"** → **"+ New"**
2. Выберите **"MySQL"**
3. Скопируйте переменные подключения (DB_HOST, DB_PASSWORD и т.д.)

## Шаг 5: Запуск миграций

1. В Railway перейдите в **"Deploy"** → **"Shell"**
2. Выполните:
```bash
php artisan migrate
php artisan db:seed
```

## Шаг 6: Проверка

После деплоя откройте предоставленный Railway URL.

---

## Команда для генерации APP_KEY

```bash
php artisan key:generate
```

---

## Тестовые аккаунты

- **ivan@example.com** / password123
- **maria@example.com** / password123

---

Нужна помощь с настройкой?