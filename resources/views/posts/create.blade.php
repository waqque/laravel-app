@extends('layouts.app')

@section('title', 'Создание статьи')

@section('content')
    <p><a href="{{ route('posts.index') }}">&larr; Вернуться к списку статей</a></p>

    <h1>Создать новую статью в БД</h1>

    {{-- Вывод ошибок валидации --}}
    @if ($errors->any())
        <div class="alert-error">
            <strong>Ошибки при заполнении:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <p>
            <label>Заголовок статьи:<br>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Введите заголовок статьи">
            </label>
        </p>

        <p>
            <label>Категория (связь BelongsTo):<br>
                <select name="category_id" required>
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Выберите категорию --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>
        </p>

        <p>
            <label><strong>Теги (связь BelongsToMany):</strong></label><br>
            @foreach($tags as $tag)
                <label style="margin-right: 12px; display: inline-block;">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                    #{{ $tag->name }}
                </label>
            @endforeach
        </p>

        <p>
            <label>Текст статьи:<br>
                <textarea name="content" rows="6" required placeholder="Введите текст статьи...">{{ old('content') }}</textarea>
            </label>
        </p>

        <p>
            <label>
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }}>
                Опубликовать статью сразу (учитывается в scopePublished)
            </label>
        </p>

        <p>
            <button type="submit">Сохранить статью в БД</button>
            <a href="{{ route('posts.index') }}" style="margin-left: 10px;">Отмена</a>
        </p>
    </form>
@endsection
