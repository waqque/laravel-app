@extends('layouts.app')

@section('title', 'Статьи (БД Eloquent)')

@section('content')
    <h1>Список статей (БД Eloquent)</h1>
    <p>
        <a href="{{ route('posts.create') }}">+ Добавить новую статью</a> |
        <a href="{{ route('api.posts.index') }}" target="_blank">Открыть ответ в JSON (API Resource)</a>
    </p>

    {{-- Сообщение об успешном действии --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Фильтрация через Query Scopes и Soft Deletes --}}
    <p style="background: #f9f9f9; padding: 8px; border: 1px solid #ddd;">
        <strong>Фильтр:</strong>
        <a href="{{ route('posts.index', ['filter' => 'all']) }}">Все посты</a> |
        <a href="{{ route('posts.index', ['filter' => 'published']) }}">Опубликованные (Query Scope)</a> |
        <a href="{{ route('posts.index', ['filter' => 'trashed']) }}">Корзина (Soft Deletes)</a>
    </p>

    @if($posts->isEmpty())
        <p><em>Постов пока нет. Добавьте первую запись!</em></p>
    @else
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Категория (BelongsTo)</th>
                <th>Теги (BelongsToMany)</th>
                <th>Отклики (MorphMany)</th>
                <th>Действия</th>
            </tr>
            @foreach($posts as $post)
                <tr style="{{ $post->trashed() ? 'background-color: #fbeae8; color: #888;' : '' }}">
                    <td>{{ $post->id }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}">
                            <strong>{{ $post->title }}</strong>
                        </a>
                        @if($post->trashed())
                            <span style="color: red; font-size: 12px;">[В корзине / Soft Deleted]</span>
                        @elseif(!$post->is_published)
                            <span style="color: gray; font-size: 12px;">[Черновик]</span>
                        @endif
                    </td>
                    <td>{{ $post->category?->name ?? '—' }}</td>
                    <td>
                        @forelse($post->tags as $tag)
                            #{{ $tag->name }}
                        @empty
                            <span style="color: #999;">нет</span>
                        @endforelse
                    </td>
                    <td>Комментариев: {{ $post->comments->count() }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}">Просмотр</a> |

                        @if($post->trashed())
                            {{-- Восстановление из мягкого удаления --}}
                            <form action="{{ route('posts.restore', $post->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="color: green; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline;">
                                    Восстановить
                                </button>
                            </form>
                        @else
                            <a href="{{ route('posts.edit', $post->id) }}">Редактировать</a> |

                            {{-- Мягкое удаление (Soft Delete) --}}
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить статью в корзину (Soft Delete)?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline;">
                                    Удалить
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <div style="margin-top: 15px;">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
