@extends('layouts.app')

@section('title', 'Отправка формы (JSON-файл)')

@section('content')
    <p><a href="{{ route('feedback.index') }}">Посмотреть таблицу с сохраненными данными &rarr;</a></p>

    <h1>Форма обратной связи</h1>
    <p>Данные из этой формы отправляются методом <strong>POST</strong> и сохраняются контроллером в отдельный JSON-файл с уникальным именем.</p>

    {{-- Сообщение об успешном сохранении --}}
    @if(session('success'))
        <div class="alert-success">
            <strong>Готово:</strong> {{ session('success') }}
            @if(session('saved_file'))
                <br>Создан файл: <code>{{ session('saved_file') }}</code>
            @endif
        </div>
    @endif

    {{-- Ошибки валидации --}}
    @if ($errors->any())
        <div class="alert-error">
            <strong>Ошибки валидации:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <p>
            <label>Ваше имя: *<br>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Иван Иванов">
            </label>
        </p>

        <p>
            <label>Электронная почта: *<br>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="ivan@example.com">
            </label>
        </p>

        <p>
            <label>Категория обращения: *<br>
                <select name="category" required>
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Выберите категорию --</option>
                    <option value="Вопрос" {{ old('category') == 'Вопрос' ? 'selected' : '' }}>Вопрос</option>
                    <option value="Предложение" {{ old('category') == 'Предложение' ? 'selected' : '' }}>Предложение</option>
                    <option value="Отзыв" {{ old('category') == 'Отзыв' ? 'selected' : '' }}>Отзыв</option>
                    <option value="Техподдержка" {{ old('category') == 'Техподдержка' ? 'selected' : '' }}>Техподдержка</option>
                    <option value="Другое" {{ old('category') == 'Другое' ? 'selected' : '' }}>Другое</option>
                </select>
            </label>
        </p>

        <p>
            <label>Тема сообщения: *<br>
                <input type="text" name="topic" value="{{ old('topic') }}" required placeholder="Краткая тема">
            </label>
        </p>

        <p>
            <label>Текст сообщения: *<br>
                <textarea name="message" rows="5" required placeholder="Текст сообщения (от 10 символов)...">{{ old('message') }}</textarea>
            </label>
        </p>

        <p>
            <button type="submit">Отправить данные (POST)</button>
        </p>
    </form>
@endsection
