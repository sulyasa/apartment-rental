# 🚀 Инструкция по загрузке через GitHub

## Шаг 1: Создайте репозиторий на GitHub

1. Перейдите на https://github.com/
2. Войдите в свой аккаунт
3. Нажмите кнопку **"+"** → **"New repository"**
4. Введите название: `apartment-rental`
5. Нажмите **"Create repository"**

## Шаг 2: Загрузите файлы на GitHub

Откройте терминал (командную строку) в папке проекта:

```bash
# Перейдите в папку проекта
cd c:\Users\izhsa\Desktop\kursovaya\apartment-rental

# Инициализируйте git (если ещё не инициализирован)
git init

# Добавьте все файлы
git add .

# Создайте первый коммит
git commit -m "Initial commit - Apartment Rental"

# Добавьте удалённый репозиторий
git remote add origin https://github.com/YOUR_USERNAME/apartment-rental.git

# Загрузите на GitHub
git push -u origin main
```

> **Примечание:** Замените `YOUR_USERNAME` на ваше имя пользователя GitHub

## Шаг 3: Подключите GitHub к хостингу

### Вариант А: 000webhost (бесплатно)

1. Войдите в 000webhost
2. Создайте новый сайт
3. Выберите **"Connect GitHub"**
4. Авторизуйтесь через GitHub
5. Выберите репозиторий `apartment-rental`
6. Нажмите **"Deploy"**

### Вариант Б: Vercel (рекомендуется)

1. Перейдите на https://vercel.com/
2. Войдите через GitHub
3. Нажмите **"New Project"**
4. Выберите репозиторий `apartment-rental`
5. Нажмите **"Deploy"**

### Вариант В: Render

1. Перейдите на https://render.com/
2. Создайте новый **Web Service**
3. Подключите GitHub репозиторий
4. Настройте:
   - Build Command: `composer install --no-dev`
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

## Шаг 4: Настройка базы данных на хостинге

После деплоя:

1. Создайте MySQL базу данных в панели хостинга
2. Создайте файл `.env` с настройками БД
3. Откройте `migrate.php` в браузере для создания таблиц

---

## Быстрые команды для терминала

```bash
# Клонировать проект (если есть на GitHub)
git clone https://github.com/YOUR_USERNAME/apartment-rental.git
cd apartment-rental
composer install
```

---

## Если нет Git на компьютере

1. Скачайте Git: https://git-scm.com/
2. Установите
3. Настройте:
```bash
git config --global user.name "Ваше Имя"
git config --global user.email "ваш@email.com"
```

---

Нужна помощь с конкретным шагом?