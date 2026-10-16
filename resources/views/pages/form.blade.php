@extends('layouts.app')

@section('title', 'Отправка формы')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Форма обратной связи</h1>
                <p class="text-secondary small mb-0">
                    Данные формы обрабатываются POST-запросом и сохраняются в формате JSON с уникальным именем в <code>storage/app/submissions/</code>.
                </p>
            </div>
            <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-table me-1"></i> Все записи
            </a>
        </div>

        {{-- Сообщение об успешном сохранении --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-start gap-3 p-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4 text-success flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <h5 class="alert-heading fw-bold mb-1">Успешно!</h5>
                    <p class="mb-2">{{ session('success') }}</p>
                    @if(session('saved_file'))
                        <div class="small bg-white p-2 rounded border text-monospace text-dark">
                            <strong>Имя созданного файла:</strong> <code>{{ session('saved_file') }}</code>
                        </div>
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-success">
                            <i class="bi bi-arrow-right me-1"></i> Посмотреть в таблице записей
                        </a>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Общий блок валидационных ошибок (если есть) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-start gap-3 p-3 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4 text-danger flex-shrink-0"></i>
                <div class="flex-grow-1">
                    <h5 class="alert-heading fw-bold mb-1">Ошибка валидации формы!</h5>
                    <p class="mb-2 small">Пожалуйста, исправьте следующие ошибки и повторите отправку:</p>
                    <ul class="mb-0 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Форма отправки POST-запроса -->
        <div class="card p-4 p-md-4 shadow-sm bg-white">
            <form action="{{ route('feedback.store') }}" method="POST" novalidate>
                @csrf

                <div class="row g-3">
                    <!-- Имя -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            Ваше имя <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Иван Иванов"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">
                            Электронная почта <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="ivan@example.com"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Категория -->
                    <div class="col-md-6">
                        <label for="category" class="form-label fw-semibold">
                            Категория обращения <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Выберите категорию...</option>
                                <option value="Вопрос" {{ old('category') == 'Вопрос' ? 'selected' : '' }}>Вопрос</option>
                                <option value="Предложение" {{ old('category') == 'Предложение' ? 'selected' : '' }}>Предложение</option>
                                <option value="Отзыв" {{ old('category') == 'Отзыв' ? 'selected' : '' }}>Отзыв</option>
                                <option value="Техподдержка" {{ old('category') == 'Техподдержка' ? 'selected' : '' }}>Техподдержка</option>
                                <option value="Другое" {{ old('category') == 'Другое' ? 'selected' : '' }}>Другое</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Тема -->
                    <div class="col-md-6">
                        <label for="topic" class="form-label fw-semibold">
                            Тема сообщения <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-chat-left-dots"></i></span>
                            <input
                                type="text"
                                class="form-control @error('topic') is-invalid @enderror"
                                id="topic"
                                name="topic"
                                value="{{ old('topic') }}"
                                placeholder="Краткое описание темы"
                                required
                            >
                            @error('topic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Сообщение -->
                    <div class="col-12">
                        <label for="message" class="form-label fw-semibold">
                            Текст сообщения <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control @error('message') is-invalid @enderror"
                            id="message"
                            name="message"
                            rows="5"
                            placeholder="Подробно опишите ваше обращение (минимум 10 символов)..."
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            Минимум 10, максимум 2000 символов.
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between align-items-center pt-2">
                        <div class="small text-muted">
                            <i class="bi bi-shield-check text-success me-1"></i> Серверная валидация Laravel
                        </div>
                        <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold">
                            <i class="bi bi-send me-1"></i> Отправить (POST)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
