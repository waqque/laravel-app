@extends('layouts.app')

@section('title', 'Редактирование статьи')

@section('content')
    <p><a href="{{ route('posts.show', $post->id) }}">&larr; Назад к просмотру статьи</a></p>

    <h1>Редактировать статью #{{ $post->id }}</h1>

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

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>Заголовок статьи:<br>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
            </label>
        </p>

        <p>
            <label>Категория (связь BelongsTo):<br>
                <select name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>
        </p>

        <p>
            <label><strong>Теги (связь BelongsToMany):</strong></label><br>
            @php
                $currentTags = old('tags', $post->tags->pluck('id')->toArray());
            @endphp
            @foreach($tags as $tag)
                <label style="margin-right: 12px; display: inline-block;">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $currentTags) ? 'checked' : '' }}>
                    #{{ $tag->name }}
                </label>
            @endforeach
        </p>

        <p>
            <label>Текст статьи:<br>
                <textarea name="content" rows="6" required>{{ old('content', $post->content) }}</textarea>
            </label>
        </p>

        <p>
            <label>
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                Опубликовано
            </label>
        </p>

        <p>
            <button type="submit">Сохранить изменения</button>
            <a href="{{ route('posts.show', $post->id) }}" style="margin-left: 10px;">Отмена</a>
        </p>
    </form>
@endsection
