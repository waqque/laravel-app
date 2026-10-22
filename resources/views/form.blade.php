@extends('layout')

@section('title', 'Форма ввода данных')

@section('content')
    <h1>Форма ввода данных</h1>

    {{-- Сообщение об успешном сохранении --}}
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ session('success') }}
            <br><a href="{{ route('data') }}">Посмотреть данные в таблице &rarr;</a>
        </div>
    @endif

    {{-- Вывод ошибок валидации --}}
    @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
            <strong>Ошибки:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Форма с отправкой POST-запроса --}}
    <form action="{{ route('form.store') }}" method="POST">
        @csrf

        <p>
            <label>Имя:<br>
                <input type="text" name="name" value="{{ old('name') }}" style="width: 300px; padding: 5px;">
            </label>
        </p>

        <p>
            <label>Email:<br>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 300px; padding: 5px;">
            </label>
        </p>

        <p>
            <label>Сообщение:<br>
                <textarea name="message" rows="4" style="width: 300px; padding: 5px;">{{ old('message') }}</textarea>
            </label>
        </p>

        <p>
            <button type="submit" style="padding: 6px 16px; cursor: pointer;">Отправить</button>
        </p>
    </form>
@endsection
