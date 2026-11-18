<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Список постов с пагинацией, фильтрацией и жадной загрузкой связей.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['category', 'tags', 'user', 'comments']);

        // Фильтры и Query Scopes
        $filter = $request->input('filter', 'all');

        if ($filter === 'published') {
            $query->published();
        } elseif ($filter === 'popular') {
            $query->popular(50);
        } elseif ($filter === 'trashed') {
            $query->onlyTrashed(); // Показать только мягко удаленные
        } else {
            $query->withTrashed(); // По умолчанию показываем все, включая удаленные (с пометкой)
        }

        if ($request->filled('category_id')) {
            $query->byCategory((int) $request->input('category_id'));
        }

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $posts = $query->latest('id')->paginate(6)->withQueryString();
        $categories = Category::all();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'currentFilter' => $filter,
        ]);
    }

    /**
     * Детальный просмотр поста со связями (BelongsTo, BelongsToMany, MorphMany).
     */
    public function show(int $id): View
    {
        $post = Post::withTrashed()
            ->with(['category', 'tags', 'user', 'comments.user'])
            ->findOrFail($id);

        // Увеличиваем счетчик просмотров
        $post->increment('views_count');

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Форма создания поста.
     */
    public function create(): View
    {
        return view('posts.create', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Сохранение нового поста.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = Post::create([
            'category_id' => $validated['category_id'],
            'user_id' => 1, // тестовый автор
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Пост успешно создан в базе данных!');
    }

    /**
     * Форма редактирования поста.
     */
    public function edit(int $id): View
    {
        $post = Post::withTrashed()->findOrFail($id);

        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Обновление поста.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $post = Post::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? ($post->published_at ?? now()) : null,
        ]);

        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Пост успешно обновлен!');
    }

    /**
     * Мягкое удаление (Soft Delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', "Пост «{$post->title}» успешно мягко удален (Soft Delete).");
    }

    /**
     * Восстановление мягко удаленного поста.
     */
    public function restore(int $id): RedirectResponse
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.show', $post->id)
            ->with('success', "Пост «{$post->title}» успешно восстановлен из корзины!");
    }
}
