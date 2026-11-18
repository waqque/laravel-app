@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <h1>Основа веб-приложения на Laravel (v2.0)</h1>
    <p>В этом проекте мы изучаем основы веб-фреймворка Laravel и работу с базой данных через <strong>Eloquent ORM</strong>.</p>

    <h3>Разделы приложения:</h3>
    <ul>
        <li>
            <a href="{{ route('posts.index') }}"><strong>Статьи (БД Eloquent)</strong></a> — просмотр списка постов из базы данных, демонстрация связей, фильтрации и мягкого удаления.
        </li>
        <li>
            <a href="{{ route('posts.create') }}">+ Добавить новую статью</a> — форма добавления записи в БД.
        </li>
        <li>
            <a href="{{ route('feedback.create') }}">Форма обратной связи</a> — отправка POST-запроса с сохранением в JSON-файл на сервере.
        </li>
        <li>
            <a href="{{ route('feedback.index') }}">Таблица файлов JSON</a> — вывод записей, сохраненных в файлы.
        </li>
        <li>
            <a href="{{ route('api.posts.index') }}" target="_blank">REST API (JSON)</a> — ответ контроллера в формате JSON через API Resource.
        </li>
    </ul>

    <h3>Что реализовано по ТЗ:</h3>
    <ol>
        <li><strong>Модели Eloquent и миграции:</strong> <code>Post</code>, <code>Category</code>, <code>Tag</code>, <code>Comment</code>.</li>
        <li><strong>Параметры моделей:</strong> настроены <code>$fillable</code> и <code>$casts</code>.</li>
        <li><strong>CRUD операции:</strong> список, просмотр, создание, редактирование и удаление.</li>
        <li><strong>Связи моделей:</strong>
            <ul>
                <li><code>BelongsTo</code> (пост принадлежит категории)</li>
                <li><code>HasMany</code> (у категории много постов)</li>
                <li><code>BelongsToMany</code> (посты и теги, связь многие-ко-многим через таблицу <code>post_tag</code>)</li>
                <li><strong>Полиморфная связь</strong> (комментарии <code>MorphTo</code> / <code>MorphMany</code>)</li>
            </ul>
        </li>
        <li><strong>Query Scopes:</strong> область запросов <code>scopePublished()</code> (только опубликованные статьи).</li>
        <li><strong>Мягкое удаление (Soft Deletes):</strong> трейт <code>SoftDeletes</code> на модели <code>Post</code>, колонка <code>deleted_at</code> и восстановление.</li>
        <li><strong>Контроллеры с ответом в JSON:</strong> <code>PostApiController</code> и <code>PostResource</code>.</li>
    </ol>
@endsection
