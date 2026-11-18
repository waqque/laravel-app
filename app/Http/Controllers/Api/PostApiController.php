<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PostApiController extends Controller
{
    /**
     * Вывод списка постов в формате JSON с поддержкой связей и Query Scopes.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Post::with(['category', 'tags', 'user', 'comments']);

        // Применение мягкого удаления: возможность запросить удаленные
        if ($request->boolean('only_trashed')) {
            $query->onlyTrashed();
        } elseif ($request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        // Применение Query Scopes
        if ($request->boolean('published', true)) {
            $query->published();
        }

        if ($request->has('popular')) {
            $minViews = (int) $request->input('popular', 50);
            $query->popular($minViews);
        }

        if ($request->filled('category_id')) {
            $query->byCategory((int) $request->input('category_id'));
        }

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $posts = $query->latest()->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Просмотр одного элемента в формате JSON со всеми связями.
     */
    public function show(int $id): PostResource
    {
        $post = Post::withTrashed()
            ->with(['category', 'tags', 'user', 'comments'])
            ->findOrFail($id);

        // Инкремент просмотров
        $post->increment('views_count');

        return new PostResource($post);
    }

    /**
     * Создание нового элемента через POST с валидацией и ответом в формате JSON.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = Post::create([
            'category_id' => $validated['category_id'],
            'user_id' => $validated['user_id'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            'content' => $validated['content'],
            'is_published' => $validated['is_published'] ?? true,
            'published_at' => ($validated['is_published'] ?? true) ? now() : null,
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        $post->load(['category', 'tags', 'user', 'comments']);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Редактирование элемента через PUT/PATCH.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'title' => 'sometimes|required|string|min:3|max:255',
            'content' => 'sometimes|required|string|min:10',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update($validated);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        $post->load(['category', 'tags', 'user', 'comments']);

        return (new PostResource($post))->response();
    }

    /**
     * Мягкое удаление элемента (Soft Delete).
     */
    public function destroy(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->delete(); // Мягкое удаление (заполняет deleted_at)

        return response()->json([
            'message' => 'Пост успешно мягко удален (Soft Delete).',
            'id' => $id,
            'deleted_at' => $post->freshTimestampString(),
        ]);
    }

    /**
     * Восстановление мягко удаленного элемента.
     */
    public function restore(int $id): JsonResponse
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore(); // Восстановление записи

        return response()->json([
            'message' => 'Пост успешно восстановлен.',
            'id' => $id,
        ]);
    }
}
