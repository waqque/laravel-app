@extends('layouts.app')

@section('title', 'Форма обратной связи')

@section('content')
<div class="card">
    <h2>Форма обратной связи</h2>
    <p style="color: #666666; font-size: 14px;">
        Заполните поля ниже. После нажатия на кнопку будет отправлен <strong>POST-запрос</strong>, контроллер проверит валидность данных и сохранит их в отдельный <strong>JSON-файл</strong> с уникальным именем.
    </p>

    {{-- Сообщение об успешной отправке --}}
    @if(session('success'))
        <div class="alert alert-success">
            <strong>Готово!</strong> {{ session('success') }}
            @if(session('saved_file'))
                <div style="margin-top: 5px;">
                    Имя файла: <code>{{ session('saved_file') }}</code>
                </div>
            @endif
            <div style="margin-top: 10px;">
                <a href="{{ route('feedback.index') }}" class="btn btn-success" style="font-size: 12px; padding: 5px 10px;">
                    Перейти к таблице записей &rarr;
                </a>
            </div>
        </div>
    @endif

    {{-- Вывод ошибок валидации --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Пожалуйста, исправьте ошибки:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Форма отправки данных -->
    <form action="{{ route('feedback.store') }}" method="POST">
        {{-- Обязательный токен безопасности CSRF в Laravel --}}
        @csrf

        <div class="form-group">
            <label for="name">Ваше имя: <span class="required">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="@error('name') is-invalid @enderror"
                placeholder="Например, Иван"
            >
            @error('name')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Электронная почта: <span class="required">*</span></label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                class="@error('email') is-invalid @enderror"
                placeholder="ivan@example.com"
            >
            @error('email')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Категория обращения: <span class="required">*</span></label>
            <select id="category" name="category" class="@error('category') is-invalid @enderror">
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Выберите категорию --</option>
                <option value="Вопрос" {{ old('category') == 'Вопрос' ? 'selected' : '' }}>Вопрос</option>
                <option value="Предложение" {{ old('category') == 'Предложение' ? 'selected' : '' }}>Предложение</option>
                <option value="Отзыв" {{ old('category') == 'Отзыв' ? 'selected' : '' }}>Отзыв</option>
                <option value="Техподдержка" {{ old('category') == 'Техподдержка' ? 'selected' : '' }}>Техподдержка</option>
                <option value="Другое" {{ old('category') == 'Другое' ? 'selected' : '' }}>Другое</option>
            </select>
            @error('category')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="topic">Тема сообщения: <span class="required">*</span></label>
            <input
                type="text"
                id="topic"
                name="topic"
                value="{{ old('topic') }}"
                class="@error('topic') is-invalid @enderror"
                placeholder="Кратко опишите тему"
            >
            @error('topic')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="message">Текст сообщения: <span class="required">*</span></label>
            <textarea
                id="message"
                name="message"
                rows="4"
                class="@error('message') is-invalid @enderror"
                placeholder="Напишите ваше сообщение здесь (от 10 символов)..."
            >{{ old('message') }}</textarea>
            @error('message')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                Отправить данные (POST)
            </button>
            <a href="{{ route('home') }}" class="btn btn-secondary" style="margin-left: 8px;">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection
