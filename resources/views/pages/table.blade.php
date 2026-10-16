@extends('layouts.app')

@section('title', 'Таблица полученных данных')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Полученные данные</h1>
                <p class="text-secondary small mb-0">
                    Данные считываются контроллером из JSON-файлов в директории <code>storage/app/submissions/</code>.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">
                    Всего записей: <strong>{{ $totalCount }}</strong>
                </span>
                <a href="{{ route('feedback.create') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Добавить запись
                </a>
            </div>
        </div>

        @if(empty($submissions))
            <!-- Пустое состояние -->
            <div class="card p-5 text-center bg-white shadow-sm">
                <div class="mb-3 text-secondary">
                    <i class="bi bi-inbox fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Записей пока нет</h4>
                <p class="text-secondary mb-4 mx-auto" style="max-width: 500px;">
                    Вы пока не сохранили ни одной записи через форму. Отправьте тестовые данные, и они автоматически появятся в этой таблице.
                </p>
                <div>
                    <a href="{{ route('feedback.create') }}" class="btn btn-danger px-4">
                        <i class="bi bi-pencil-square me-2"></i> Заполнить форму обратной связи
                    </a>
                </div>
            </div>
        @else
            <!-- Таблица данных -->
            <div class="card shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col" style="min-width: 140px;">Дата / Время</th>
                                <th scope="col" style="min-width: 150px;">Имя</th>
                                <th scope="col" style="min-width: 180px;">Email</th>
                                <th scope="col" style="min-width: 130px;">Категория</th>
                                <th scope="col" style="min-width: 160px;">Тема</th>
                                <th scope="col" style="min-width: 250px;">Сообщение</th>
                                <th scope="col" class="text-end" style="min-width: 140px;">JSON Файл</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $index => $item)
                                <tr>
                                    <td class="text-muted small fw-semibold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="small fw-semibold text-dark">{{ $item['created_at'] ?? '—' }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">ID: {{ \Illuminate\Support\Str::limit($item['id'] ?? '', 14) }}</div>
                                    </td>
                                    <td class="fw-semibold text-dark">{{ $item['name'] ?? '—' }}</td>
                                    <td>
                                        <a href="mailto:{{ $item['email'] ?? '' }}" class="text-decoration-none">
                                            {{ $item['email'] ?? '—' }}
                                        </a>
                                    </td>
                                    <td>
                                        @php
                                            $cat = $item['category'] ?? 'Другое';
                                            $badgeClass = match($cat) {
                                                'Вопрос' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
                                                'Предложение' => 'bg-success-subtle text-success border border-success-subtle',
                                                'Отзыв' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                                                'Техподдержка' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $cat }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $item['topic'] ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary small" style="max-height: 80px; overflow-y: auto;">
                                            {{ $item['message'] ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        @if(!empty($item['_filename']))
                                            <a href="{{ route('feedback.download', $item['_filename']) }}" class="btn btn-sm btn-outline-primary" title="Скачать JSON файл">
                                                <i class="bi bi-download me-1"></i> JSON
                                            </a>
                                            <div class="text-muted text-truncate ms-auto mt-1" style="max-width: 130px; font-size: 0.7rem;" title="{{ $item['_filename'] }}">
                                                {{ $item['_filename'] }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
