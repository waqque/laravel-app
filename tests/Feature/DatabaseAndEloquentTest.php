<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseAndEloquentTest extends TestCase
{
    use RefreshDatabase;

    protected Category $category;
    protected Tag $tag;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['name' => 'Иван Автор']);
        $this->category = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $this->tag = Tag::create(['name' => 'PHP', 'slug' => 'php']);
    }

    /**
     * Тест: Модели и связи (BelongsTo, HasMany, BelongsToMany, MorphMany).
     */
    public function test_eloquent_relationships_work(): void
    {
        $post = Post::create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'title' => 'Тестовая статья о связях',
            'slug' => 'test-post-relations',
            'content' => 'Содержание тестовой статьи для проверки связей.',
            'is_published' => true,
        ]);

        // BelongsToMany: привязка тега
        $post->tags()->attach($this->tag->id);

        // MorphMany: полиморфный комментарий
        $comment = $post->comments()->create([
            'author_name' => 'Читатель',
            'body' => 'Отличный пост!',
        ]);

        // Проверка BelongsTo
        $this->assertEquals($this->category->id, $post->category->id);
        $this->assertEquals($this->user->id, $post->user->id);

        // Проверка HasMany
        $this->assertTrue($this->category->posts->contains($post));

        // Проверка BelongsToMany
        $this->assertTrue($post->tags->contains($this->tag));
        $this->assertTrue($this->tag->posts->contains($post));

        // Проверка полиморфной связи MorphMany / MorphTo
        $this->assertTrue($post->comments->contains($comment));
        $this->assertEquals(Post::class, $comment->commentable_type);
        $this->assertEquals($post->id, $comment->commentable->id);
    }

    /**
     * Тест: Query Scopes (scopePublished, scopePopular, scopeByCategory).
     */
    public function test_query_scopes_work(): void
    {
        $publishedPost = Post::create([
            'category_id' => $this->category->id,
            'title' => 'Опубликованная',
            'slug' => 'pub',
            'content' => 'Текст',
            'is_published' => true,
            'views_count' => 120,
        ]);

        $draftPost = Post::create([
            'category_id' => $this->category->id,
            'title' => 'Черновик',
            'slug' => 'draft',
            'content' => 'Текст',
            'is_published' => false,
            'views_count' => 10,
        ]);

        // scopePublished
        $published = Post::published()->get();
        $this->assertTrue($published->contains($publishedPost));
        $this->assertFalse($published->contains($draftPost));

        // scopePopular
        $popular = Post::popular(50)->get();
        $this->assertTrue($popular->contains($publishedPost));
        $this->assertFalse($popular->contains($draftPost));

        // scopeByCategory
        $byCat = Post::byCategory($this->category->id)->get();
        $this->assertCount(2, $byCat);
    }

    /**
     * Тест: Мягкое удаление (Soft Deletes) и восстановление.
     */
    public function test_soft_deletes_and_restore_work(): void
    {
        $post = Post::create([
            'category_id' => $this->category->id,
            'title' => 'Пост для удаления',
            'slug' => 'to-delete',
            'content' => 'Содержимое',
            'is_published' => true,
        ]);

        // Выполняем мягкое удаление
        $post->delete();

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
        $this->assertTrue($post->trashed());

        // Обычный запрос не видит удаленный пост
        $this->assertNull(Post::find($post->id));

        // withTrashed() видит
        $this->assertNotNull(Post::withTrashed()->find($post->id));

        // Восстановление
        $post->restore();
        $this->assertFalse($post->trashed());
        $this->assertNotNull(Post::find($post->id));
    }

    /**
     * Тест: Веб CRUD контроллера (список, просмотр, создание, редактирование, удаление).
     */
    public function test_web_crud_operations(): void
    {
        // 1. Список
        $this->get(route('posts.index'))->assertStatus(200);

        // 2. Создание
        $response = $this->post(route('posts.store'), [
            'category_id' => $this->category->id,
            'title' => 'Новая статья через контроллер',
            'content' => 'Достаточно длинный текст статьи для валидации.',
            'is_published' => '1',
            'tags' => [$this->tag->id],
        ]);
        $response->assertRedirect();

        $post = Post::where('title', 'Новая статья через контроллер')->first();
        $this->assertNotNull($post);
        $this->assertTrue($post->tags->contains($this->tag));

        // 3. Просмотр
        $this->get(route('posts.show', $post->id))->assertStatus(200)->assertSee('Новая статья через контроллер');

        // 4. Редактирование
        $this->put(route('posts.update', $post->id), [
            'category_id' => $this->category->id,
            'title' => 'Обновленный заголовок',
            'content' => 'Обновленный текст статьи.',
            'is_published' => '1',
        ])->assertRedirect();
        $this->assertEquals('Обновленный заголовок', $post->fresh()->title);

        // 5. Удаление (Soft Delete)
        $this->delete(route('posts.destroy', $post->id))->assertRedirect();
        $this->assertSoftDeleted('posts', ['id' => $post->id]);

        // 6. Восстановление
        $this->post(route('posts.restore', $post->id))->assertRedirect();
        $this->assertFalse($post->fresh()->trashed());
    }

    /**
     * Тест: Добавление полиморфного комментария через контроллер.
     */
    public function test_add_polymorphic_comment_to_post(): void
    {
        $post = Post::create([
            'category_id' => $this->category->id,
            'title' => 'Пост для комментариев',
            'slug' => 'post-comments',
            'content' => 'Текст',
        ]);

        $response = $this->post(route('posts.comments.store', $post->id), [
            'author_name' => 'Мария',
            'body' => 'Отличный полиморфный комментарий!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'author_name' => 'Мария',
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
        ]);
    }

    /**
     * Тест: REST API контроллер с ответом в формате JSON (API Resource).
     */
    public function test_json_api_endpoints_with_resources(): void
    {
        $post = Post::create([
            'category_id' => $this->category->id,
            'title' => 'API Статья',
            'slug' => 'api-post',
            'content' => 'Текст для API ресурса',
            'is_published' => true,
        ]);
        $post->tags()->attach($this->tag->id);

        // 1. GET /api/posts (Index)
        $indexResponse = $this->getJson(route('api.posts.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'content', 'is_published', 'category', 'tags', 'comments']
            ]
        ]);

        // 2. GET /api/posts/{id} (Show)
        $showResponse = $this->getJson(route('api.posts.show', $post->id));
        $showResponse->assertStatus(200);
        $showResponse->assertJsonPath('data.title', 'API Статья');

        // 3. POST /api/posts (Store)
        $storeResponse = $this->postJson(route('api.posts.store'), [
            'category_id' => $this->category->id,
            'title' => 'Статья созданная через API',
            'content' => 'Текст новой статьи через API.',
            'tags' => [$this->tag->id],
        ]);
        $storeResponse->assertStatus(201);
        $storeResponse->assertJsonPath('data.title', 'Статья созданная через API');

        // 4. DELETE /api/posts/{id} (Destroy - Soft Delete)
        $deleteResponse = $this->deleteJson(route('api.posts.destroy', $post->id));
        $deleteResponse->assertStatus(200);
        $this->assertSoftDeleted('posts', ['id' => $post->id]);

        // 5. POST /api/posts/{id}/restore (Restore)
        $restoreResponse = $this->postJson(route('api.posts.restore', $post->id));
        $restoreResponse->assertStatus(200);
        $this->assertFalse($post->fresh()->trashed());
    }
}
