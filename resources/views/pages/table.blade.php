@extends('layouts.app')

@section('title', 'Таблица сохраненных JSON-файлов')

@section('content')
    <p><a href="{{ route('feedback.create') }}">+ Заполнить форму еще раз</a></p>

    <h1>Полученные данные (из JSON файлов)</h1>
    <p>Всего файлов в хранилище: <strong>{{ $totalCount }}</strong></p>

    @if(empty($submissions))
        <p><em>Сохраненных файлов пока нет. Отправьте данные через форму.</em></p>
    @else
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>
                <th>№</th>
                <th>Дата</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Категория</th>
                <th>Тема</th>
                <th>Сообщение</th>
                <th>Файл</th>
            </tr>
            @foreach($submissions as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['created_at'] ?? '—' }}</td>
                    <td><strong>{{ $item['name'] ?? '—' }}</strong></td>
                    <td><a href="mailto:{{ $item['email'] ?? '' }}">{{ $item['email'] ?? '—' }}</a></td>
                    <td>{{ $item['category'] ?? '—' }}</td>
                    <td>{{ $item['topic'] ?? '—' }}</td>
                    <td>{{ $item['message'] ?? '—' }}</td>
                    <td>
                        @if(!empty($item['_filename']))
                            <a href="{{ route('feedback.download', $item['_filename']) }}">Скачать JSON</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
