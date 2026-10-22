@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h1>Основа веб-приложения на Laravel</h1>
    <p>Это простая учебная работа на фреймворке Laravel.</p>

    <h3>Ссылки:</h3>
    <ul>
        <li><a href="{{ route('feedback.create') }}">Перейти к форме</a></li>
        <li><a href="{{ route('feedback.index') }}">Посмотреть таблицу с записями (всего: {{ $submissionsCount }})</a></li>
    </ul>

    <h3>О проекте:</h3>
    <p>В проекте сделано:</p>
    <ul>
        <li>Базовая настройка (часовой пояс: {{ config('app.timezone') }}, локаль: {{ config('app.locale') }}, debug-режим)</li>
        <li>Маршруты GET и POST</li>
        <li>Контроллеры</li>
        <li>Шаблоны Blade (лейаут, хедер, футер)</li>
        <li>Форма с валидацией и сохранением в JSON-файл</li>
        <li>Таблица со всеми сохраненными записями</li>
    </ul>
@endsection
