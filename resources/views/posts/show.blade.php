@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <p>
        <a href="{{ route('posts.index') }}">&larr; Назад к списку статей</a> |
        <a href="{{ route('api.posts.show', $post->id) }}" target="_blank">Посмотреть в формате JSON (API Resource)</a>
    </p>

    {{-- Сообщение об успешном действии --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Плашка, если статья мягко удалена --}}
    @if($post->trashed())
        <div style="background-color: #fbeae8; border: 1px solid #e0b4b4; padding: 10px; margin-bottom: 15px;">
            <strong style="color: red;">Внимание: эта статья находится в корзине (Soft Deleted).</strong>
            <form action="{{ route('posts.restore', $post->id) }}" method="POST" style="display: inline; margin-left: 10px;">
                @csrf
                <button type="submit">Восстановить статью</button>
            </form>
        </div>
    @endif

    <h1>{{ $post->title }}</h1>

    <p style="color: #666; font-size: 14px;">
        Категория (<strong>BelongsTo</strong>): <strong>{{ $post->category?->name ?? 'Без категории' }}</strong> |
        Статус: {{ $post->is_published ? 'Опубликовано' : 'Черновик' }}
    </p>

    <div style="background: #fafafa; border: 1px solid #eee; padding: 15px; margin: 15px 0;">
        <p style="white-space: pre-line; margin: 0;">{{ $post->content }}</p>
    </div>

    {{-- Демонстрация связи BelongsToMany --}}
    <p>
        <strong>Теги (BelongsToMany):</strong>
        @forelse($post->tags as $tag)
            <span style="background: #eef; padding: 2px 6px; border: 1px solid #cce; border-radius: 3px; font-size: 13px;">
                #{{ $tag->name }}
            </span>
        @empty
            <em>Тегов нет</em>
        @endforelse
    </p>

    {{-- Действия над статьей --}}
    <p>
        @if(!$post->trashed())
            <a href="{{ route('posts.edit', $post->id) }}">Редактировать статью</a> |
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить статью в корзину (Soft Delete)?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: red; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline;">
                    Удалить (Soft Delete)
                </button>
            </form>
        @endif
    </p>

    <hr>

    {{-- Демонстрация полиморфной связи MorphMany --}}
    <h3>Комментарии к статье (Полиморфная связь MorphMany)</h3>

    @if($post->comments->isEmpty())
        <p><em>Комментариев пока нет. Вы можете оставить первый комментарий:</em></p>
    @else
        <ul>
            @foreach($post->comments as $comment)
                <li style="margin-bottom: 10px;">
                    <strong>{{ $comment->author_name }}</strong>:
                    <p style="margin: 2px 0 0 0;">{{ $comment->body }}</p>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Форма добавления комментария --}}
    <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" style="background: #fdfdfd; border: 1px dashed #ccc; padding: 12px; margin-top: 15px;">
        @csrf
        <h4>Оставить комментарий:</h4>
        <p>
            <label>Ваше имя:<br>
                <input type="text" name="author_name" required style="width: 250px;">
            </label>
        </p>
        <p>
            <label>Текст комментария:<br>
                <textarea name="body" rows="3" required style="width: 350px;"></textarea>
            </label>
        </p>
        <p>
            <button type="submit">Отправить комментарий</button>
        </p>
    </form>
@endsection
