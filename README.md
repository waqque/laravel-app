# Laravel Web Application (v2.0)

Учебное веб-приложение на базе фреймворка Laravel. Включает базовую настройку, сохранение данных формы в JSON-файлы, а также полноценную работу с базой данных через **Eloquent ORM**.

---

## 🚀 Основные возможности

### Часть 1: Базовая основа приложения
- **Настройки**: Секретный ключ (`APP_KEY`), часовой пояс `Europe/Moscow`, локаль `ru`, режим отладки `APP_DEBUG=true`.
- **Маршрутизация**: GET и POST маршруты для страниц и формы.
- **Лейаут и шаблоны Blade**: Базовый шаблон (`layouts/app.blade.php`), подключение хедера (`partials/header.blade.php`) и футера (`partials/footer.blade.php`).
- **Форма с сохранением в JSON**: Валидация полей, сохранение в файл `storage/app/submissions/*.json` с уникальным именем, вывод таблицы полученных данных (`/submissions`).

### Часть 2: Работа с базой данных и Eloquent ORM
- **Модели и миграции**:
  - `Post` — статьи/посты (таблица `posts`)
  - `Category` — категории (таблица `categories`)
  - `Tag` — теги (таблица `tags`)
  - `Comment` — комментарии (таблица `comments`)
  - `User` — авторы постов и комментариев (таблица `users`)
- **Параметры моделей**:
  - Настроены массивы `$fillable` для безопасного массового заполнения.
  - Настроены преобразования типов `$casts` (`is_published => boolean`, `views_count => integer`).
- **Связи между моделями (Relationships)**:
  - `BelongsTo`: `Post -> category`, `Post -> user`, `Comment -> user`
  - `HasMany`: `Category -> posts`, `User -> posts`
  - `BelongsToMany`: `Post <-> Tag` через промежуточную таблицу `post_tag`
  - **Полиморфная связь**: `Comment` (`commentable()` -> `morphTo`) может прикрепляться к разным сущностям (`Post`, `Category` через `morphMany`).
- **Query Scopes**:
  - `scopePublished($query)` — только опубликованные посты
  - `scopePopular($query, $minViews = 100)` — популярные посты с просмотрами от 100
  - `scopeByCategory($query, $categoryId)` — фильтрация по категории
  - `scopeSearch($query, $term)` — поиск по заголовку и тексту
- **Мягкое удаление (Soft Deletes)**:
  - Трейт `SoftDeletes` для модели `Post`.
  - Возможность просмотра корзины, мягкого удаления и восстановления постов (`/posts/{id}/restore`).
- **CRUD через веб-контроллер (`PostController`)**:
  - `GET /posts` — список статей с возможностью фильтрации по scopes и статусу удаления
  - `GET /posts/create` — форма создания статьи
  - `POST /posts` — сохранение новой статьи и привязка тегов
  - `GET /posts/{id}` — подробный просмотр статьи, ее категории, тегов и полиморфных комментариев
  - `GET /posts/{id}/edit` — форма редактирования статьи
  - `PUT /posts/{id}` — обновление данных и синхронизация тегов
  - `DELETE /posts/{id}` — мягкое удаление статьи
  - `POST /posts/{id}/restore` — восстановление статьи из корзины
  - `POST /posts/{id}/comments` — добавление комментария к посту
- **JSON API с использованием API Resource (`PostApiController`)**:
  - `PostResource`, `CategoryResource`, `TagResource`, `CommentResource`
  - `GET /api/posts` — список статей в формате JSON (поддерживает `?filter=published`, `?filter=popular`, `?filter=trashed`)
  - `GET /api/posts/{id}` — данные конкретной статьи с загруженными связями
  - `POST /api/posts` — создание статьи через API (валидация + ответ 201 Created)
  - `PUT /api/posts/{id}` — обновление статьи через API
  - `DELETE /api/posts/{id}` — мягкое удаление статьи через API
  - `POST /api/posts/{id}/restore` — восстановление статьи через API

---

## 🛠️ Запуск проекта

```bash
# 1. Установка зависимостей
composer install

# 2. Настройка окружения и генерация ключа
cp .env.example .env
php artisan key:generate

# 3. Выполнение миграций и наполнение базы данных
php artisan migrate --seed

# 4. Запуск сервера разработки
php artisan serve
```

Приложение доступно по адресу: **http://127.0.0.1:8000**

---

## 🧪 Запуск тестов

```bash
php artisan test
```
Покрыты все ключевые функции: валидация, сохранение в JSON, операции Eloquent, связи, query scopes, soft delete и API resources.
