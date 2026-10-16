@extends('layouts.app')

@section('title', 'Таблица данных')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h2>Полученные данные</h2>
            <p style="color: #666666; font-size: 14px; margin: 0;">
                Здесь отображаются все записи, сохраненные контроллером в файлы формата JSON в каталоге <code>storage/app/submissions/</code>.
            </p>
        </div>
        <div>
            <a href="{{ route('feedback.create') }}" class="btn btn-primary" style="font-size: 13px;">
                + Добавить новую запись
            </a>
        </div>
    </div>

    @if(empty($submissions))
        {{-- Состояние, когда записей еще нет --}}
        <div style="text-align: center; padding: 40px 20px; background-color: #fafafa; border: 1px dashed #cccccc; border-radius: 4px;">
            <p style="font-size: 16px; color: #555555; margin-bottom: 15px;">
                В хранилище пока нет ни одного сохраненного файла.
            </p>
            <a href="{{ route('feedback.create') }}" class="btn btn-success">
                Заполнить форму обратной связи
            </a>
        </div>
    @else
        <p style="font-size: 13px; color: #555555; margin-bottom: 10px;">
            Всего записей: <strong>{{ $totalCount }}</strong>
        </p>

        <!-- Простая и наглядная таблица -->
        <div style="overflow-x: auto;">
            <table class="simple-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">№</th>
                        <th style="width: 140px;">Дата</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Категория</th>
                        <th>Тема</th>
                        <th>Сообщение</th>
                        <th style="width: 90px; text-align: center;">Файл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="font-size: 12px; color: #555555;">{{ $item['created_at'] ?? '—' }}</td>
                            <td><strong>{{ $item['name'] ?? '—' }}</strong></td>
                            <td><a href="mailto:{{ $item['email'] ?? '' }}">{{ $item['email'] ?? '—' }}</a></td>
                            <td><span class="badge">{{ $item['category'] ?? '—' }}</span></td>
                            <td>{{ $item['topic'] ?? '—' }}</td>
                            <td style="max-width: 250px; word-break: break-word;">{{ $item['message'] ?? '—' }}</td>
                            <td style="text-align: center;">
                                @if(!empty($item['_filename']))
                                    <a href="{{ route('feedback.download', $item['_filename']) }}" class="btn btn-secondary" style="font-size: 11px; padding: 4px 8px;">
                                        Скачать
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
