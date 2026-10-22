@extends('layouts.app')

@section('title', 'Форма обратной связи')

@section('content')
    <h1>Форма обратной связи</h1>
    <p>Заполните форму ниже. Данные будут отправлены через POST-запрос и сохранены в файл JSON.</p>

    {{-- Сообщение об успешном сохранении --}}
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px;">
            <strong>Успешно:</strong> {{ session('success') }}
            @if(session('saved_file'))
                <br>Файл: <code>{{ session('saved_file') }}</code>
            @endif
            <br><a href="{{ route('feedback.index') }}">Перейти к таблице &rarr;</a>
        </div>
    @endif

    {{-- Вывод ошибок валидации --}}
    @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px;">
            <strong>Ошибки:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <p>
            <label>Имя:<br>
                <input type="text" name="name" value="{{ old('name') }}" style="width: 300px; padding: 4px;">
            </label>
            @error('name')
                <br><span style="color: red; font-size: 13px;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Email:<br>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 300px; padding: 4px;">
            </label>
            @error('email')
                <br><span style="color: red; font-size: 13px;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Категория:<br>
                <select name="category" style="width: 300px; padding: 4px;">
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Выберите категорию --</option>
                    <option value="Вопрос" {{ old('category') == 'Вопрос' ? 'selected' : '' }}>Вопрос</option>
                    <option value="Предложение" {{ old('category') == 'Предложение' ? 'selected' : '' }}>Предложение</option>
                    <option value="Отзыв" {{ old('category') == 'Отзыв' ? 'selected' : '' }}>Отзыв</option>
                    <option value="Техподдержка" {{ old('category') == 'Техподдержка' ? 'selected' : '' }}>Техподдержка</option>
                    <option value="Другое" {{ old('category') == 'Другое' ? 'selected' : '' }}>Другое</option>
                </select>
            </label>
            @error('category')
                <br><span style="color: red; font-size: 13px;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Тема:<br>
                <input type="text" name="topic" value="{{ old('topic') }}" style="width: 300px; padding: 4px;">
            </label>
            @error('topic')
                <br><span style="color: red; font-size: 13px;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Сообщение:<br>
                <textarea name="message" rows="5" style="width: 400px; padding: 4px;">{{ old('message') }}</textarea>
            </label>
            @error('message')
                <br><span style="color: red; font-size: 13px;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <button type="submit" style="padding: 6px 14px; cursor: pointer;">Отправить данные</button>
        </p>
    </form>
@endsection
