@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Hero Card -->
        <div class="card bg-white p-4 p-md-5 mb-4 shadow-sm">
            <div class="row align-items-center gy-4">
                <div class="col-md-8">
                    <span class="badge bg-danger mb-2 px-3 py-2 fs-7">Laravel {{ app()->version() }} &bull; Релиз v1.0</span>
                    <h1 class="display-6 fw-bold mb-3 text-dark">
                        Основа веб-приложения на Laravel
                    </h1>
                    <p class="lead text-secondary mb-4">
                        Данное приложение демонстрирует полный цикл работы с фреймворком: архитектуру MVC, Blade-лейауты с компонентами, маршрутизацию GET и POST запросов, валидацию данных и сохранение информации в уникальные JSON-файлы.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('feedback.create') }}" class="btn btn-danger btn-lg px-4">
                            <i class="bi bi-pencil-square me-2"></i> Перейти к форме
                        </a>
                        <a href="{{ route('feedback.index') }}" class="btn btn-outline-dark btn-lg px-4">
                            <i class="bi bi-table me-2"></i> Просмотреть таблицу ({{ $submissionsCount }})
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4 bg-light rounded-4 border">
                        <div class="display-4 fw-bold text-danger">{{ $submissionsCount }}</div>
                        <div class="text-secondary fw-semibold">сохраненных JSON-файлов</div>
                        <small class="text-muted d-block mt-2">В каталоге <code>storage/app/submissions</code></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="text-danger mb-3">
                        <i class="bi bi-gear-wide-connected fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Базовая конфигурация</h5>
                    <p class="text-secondary small mb-3">
                        Настроены все ключевые параметры системы:
                    </p>
                    <ul class="list-unstyled small mb-0 text-secondary">
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Секретный ключ (<code>APP_KEY</code>)</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Часовой пояс: <strong>{{ config('app.timezone') }}</strong></li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Локаль: <strong>{{ config('app.locale') }}</strong></li>
                        <li><i class="bi bi-check2 text-success me-1"></i> Режим отладки: <strong>{{ config('app.debug') ? 'Включен' : 'Выключен' }}</strong></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="text-primary mb-3">
                        <i class="bi bi-filetype-json fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Форма и сохранение в JSON</h5>
                    <p class="text-secondary small mb-3">
                        Отправка формы через POST-запрос с автоматической генерацией уникального имени файла и сохранением в формате JSON.
                    </p>
                    <ul class="list-unstyled small mb-0 text-secondary">
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> CSRF-защита (<code>@csrf</code>)</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Серверная валидация полей</li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Уникальные имена файлов</li>
                        <li><i class="bi bi-check2 text-success me-1"></i> Flash-уведомление об успехе</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="text-success mb-3">
                        <i class="bi bi-layout-text-window-reverse fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Лейауты и Таблица</h5>
                    <p class="text-secondary small mb-3">
                        Единый базовый шаблон с модульными вставками хедера и футера, а также страница вывода данных в адаптивной таблице.
                    </p>
                    <ul class="list-unstyled small mb-0 text-secondary">
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Базовый лейаут <code>layouts.app</code></li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Вставки <code>partials.header / footer</code></li>
                        <li class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Адаптивная таблица с бейджами</li>
                        <li><i class="bi bi-check2 text-success me-1"></i> Скачивание исходных JSON</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
