# Laravel Web Application Base (v1.0)

Основа веб-приложения на базе фреймворка Laravel 13 с модульной архитектурой представлений Blade, валидацией данных, сохранением в файлы JSON с уникальными именами и табличным отображением.

---

## 🚀 Основные возможности

1. **Базовая конфигурация приложения**:
   - Секретный ключ шифрования (`APP_KEY` AES-256-CBC)
   - Часовой пояс: `Europe/Moscow` (`config/app.php` и `.env`)
   - Локаль: `ru` (с fallback `en`)
   - Режим отладки: `APP_DEBUG=true`

2. **Маршрутизация (GET и POST)**:
   - `GET /` — Главная страница приложения с обзором и статистикой.
   - `GET /feedback` — Страница формы для отправки обращения.
   - `POST /feedback` — Обработчик отправки формы с серверной валидацией и сохранением в JSON.
   - `GET /submissions` — Страница со списком всех полученных данных в виде таблицы.
   - `GET /submissions/download/{filename}` — Скачивание исходного JSON-файла.

3. **Контроллеры**:
   - `App\Http\Controllers\HomeController` — обработка главной страницы.
   - `App\Http\Controllers\FeedbackController` — обработка формы, валидация полей, генерация уникального имени файла и сохранение в JSON (`storage/app/submissions/*.json`), а также чтение и вывод записей в таблицу.

4. **Представления (Blade)**:
   - Базовый лейаут: `resources/views/layouts/app.blade.php`
   - Вставка хедера с логотипом и меню: `resources/views/partials/header.blade.php`
   - Вставка футера: `resources/views/partials/footer.blade.php`
   - Главная страница: `resources/views/pages/home.blade.php`
   - Страница формы: `resources/views/pages/form.blade.php` (CSRF-защита `@csrf`, вывод ошибок `$errors`, вывод flash-сообщения `session('success')`)
   - Страница таблицы: `resources/views/pages/table.blade.php` (адаптивная таблица, счетчик записей, статусные бейджи)

5. **Тестирование**:
   - Полноценные Feature-тесты (`tests/Feature/FeedbackTest.php`), покрывающие все сценарии валидации, сохранения в JSON, скачивания и табличного вывода.

---

## 🛠️ Запуск приложения

```bash
# Установка зависимостей (если разворачивается заново)
composer install

# Генерация ключа приложения (если не был создан)
php artisan key:generate

# Запуск встроенного веб-сервера
php artisan serve
```

После запуска приложение будет доступно по адресу: **http://127.0.0.1:8000**

---

## 📁 Структура сохраненных данных JSON

Файлы сохраняются в директорию `storage/app/submissions/` с уникальным именем формата:
`submission_YYYYMMDD_HHMMSS_<uniqid>.json`

Пример содержимого файла:
```json
{
    "id": "sub_6ad19915526a18.96379549",
    "created_at": "2026-10-16 06:25:09",
    "name": "Иван Иванов",
    "email": "ivan@example.com",
    "topic": "Вопрос по функционалу",
    "category": "Вопрос",
    "message": "Пример текста сообщения, сохраненного через форму.",
    "meta": {
        "user_agent": "Mozilla/5.0 ...",
        "ip": "127.0.0.1"
    }
}
```

---

## 🏷️ Версионирование

- **Версия**: `v1.0` (зафиксирована тегом в Git)
