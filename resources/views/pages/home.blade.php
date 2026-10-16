@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="card">
    <h1>Основа веб-приложения на Laravel</h1>
    <p>
        Привет! Это наш первый учебный проект на фреймворке <strong>Laravel</strong>.
        Здесь мы учимся основам веб-разработки: маршрутизации (роутам), контроллерам, шаблонизатору Blade, обработке форм и работе с файлами.
    </p>

    <div style="background-color: #eef2f7; border-left: 4px solid #3498db; padding: 12px 16px; margin: 20px 0; border-radius: 2px;">
        <strong>Что сделано в проекте:</strong>
        <ul style="margin-left: 20px; margin-top: 8px;">
            <li>Создан проект через Composer и зафиксирована версия <code>v1.0</code>.</li>
            <li>Настроены базовые параметры: ключ шифрования, часовой пояс (<code>{{ config('app.timezone') }}</code>), русская локаль (<code>{{ config('app.locale') }}</code>) и режим отладки.</li>
            <li>Настроены роуты с методами <strong>GET</strong> и <strong>POST</strong>.</li>
            <li>Созданы контроллеры для разделения логики.</li>
            <li>Созданы Blade-шаблоны: базовый лейаут с вставками для хедера и футера.</li>
            <li>Форма с валидацией, которая сохраняет данные в уникальные JSON-файлы.</li>
            <li>Страница с выводом всех сохраненных записей в виде таблицы.</li>
        </ul>
    </div>

    <div style="display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
        <a href="{{ route('feedback.create') }}" class="btn btn-primary">
            Перейти к заполнению формы &rarr;
        </a>
        <a href="{{ route('feedback.index') }}" class="btn btn-secondary">
            Посмотреть таблицу записей (всего: {{ $submissionsCount }})
        </a>
    </div>
</div>
@endsection
