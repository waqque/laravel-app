@extends('layouts.app')

@section('title', 'Таблица данных')

@section('content')
    <h1>Полученные данные</h1>
    <p>Всего записей: <strong>{{ $totalCount }}</strong></p>
    <p><a href="{{ route('feedback.create') }}">+ Добавить новую запись через форму</a></p>

    @if(empty($submissions))
        <p><em>Записей пока нет. Заполните и отправьте форму.</em></p>
    @else
        <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #f0f0f0;">
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
                    <td>{{ $item['name'] ?? '—' }}</td>
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
