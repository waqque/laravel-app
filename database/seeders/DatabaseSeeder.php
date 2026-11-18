<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Создаем пользователя-автора
        $author = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Александр Автор',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Создаем категории
        $catWeb = Category::create([
            'name' => 'Веб-разработка',
            'slug' => 'web-dev',
            'description' => 'Статьи о современных веб-технологиях',
        ]);

        $catLaravel = Category::create([
            'name' => 'Laravel Framework',
            'slug' => 'laravel',
            'description' => 'Все о разработке на фреймворке Laravel',
        ]);

        $catDatabase = Category::create([
            'name' => 'Базы данных',
            'slug' => 'databases',
            'description' => 'Реляционные БД, SQL и ORM',
        ]);

        // 3. Создаем теги
        $tagPhp = Tag::create(['name' => 'PHP', 'slug' => 'php']);
        $tagEloquent = Tag::create(['name' => 'Eloquent', 'slug' => 'eloquent']);
        $tagApi = Tag::create(['name' => 'REST API', 'slug' => 'rest-api']);
        $tagArchitecture = Tag::create(['name' => 'Архитектура', 'slug' => 'architecture']);

        // 4. Создаем посты со связями
        $post1 = Post::create([
            'category_id' => $catLaravel->id,
            'user_id' => $author->id,
            'title' => 'Погружение в Eloquent ORM: Связи и Scopes',
            'slug' => 'dive-into-eloquent-orm',
            'content' => 'Eloquent — это мощная реализация ActiveRecord в Laravel. Она позволяет легко работать со связями BelongsTo, HasMany, BelongsToMany и полиморфизмом.',
            'is_published' => true,
            'views_count' => 150,
            'published_at' => now()->subDays(2),
        ]);
        $post1->tags()->sync([$tagPhp->id, $tagEloquent->id, $tagArchitecture->id]);

        $post2 = Post::create([
            'category_id' => $catLaravel->id,
            'user_id' => $author->id,
            'title' => 'Создание JSON API с помощью Laravel API Resources',
            'slug' => 'creating-json-api-with-resources',
            'content' => 'API Resources в Laravel служат слоем трансформации между моделями Eloquent и JSON-ответами, которые отправляются клиенту.',
            'is_published' => true,
            'views_count' => 85,
            'published_at' => now()->subDay(),
        ]);
        $post2->tags()->sync([$tagPhp->id, $tagApi->id]);

        $post3 = Post::create([
            'category_id' => $catDatabase->id,
            'user_id' => $author->id,
            'title' => 'Мягкое удаление (Soft Deletes) в базах данных',
            'slug' => 'soft-deletes-in-databases',
            'content' => 'Мягкое удаление позволяет помечать записи как удаленные без физического удаления строк из базы данных.',
            'is_published' => true,
            'views_count' => 45,
            'published_at' => now(),
        ]);
        $post3->tags()->sync([$tagArchitecture->id]);

        // Пост в черновике (is_published = false) для демонстрации ScopePublished
        $postDraft = Post::create([
            'category_id' => $catWeb->id,
            'user_id' => $author->id,
            'title' => 'Черновик: Планы развития архитектуры',
            'slug' => 'draft-architecture-plans',
            'content' => 'Этот пост еще не опубликован и отфильтровывается скоупом scopePublished.',
            'is_published' => false,
            'views_count' => 5,
            'published_at' => null,
        ]);

        // Мягко удаленный пост для демонстрации SoftDeletes
        $postDeleted = Post::create([
            'category_id' => $catWeb->id,
            'user_id' => $author->id,
            'title' => 'Устаревшая новость (мягко удалена)',
            'slug' => 'old-archived-news',
            'content' => 'Этот пост был перемещен в корзину с помощью SoftDeletes.',
            'is_published' => true,
            'views_count' => 12,
            'published_at' => now()->subMonths(1),
        ]);
        $postDeleted->delete(); // Вызываем мягкое удаление!

        // 5. Создаем полиморфные комментарии
        $post1->comments()->create([
            'user_id' => $author->id,
            'author_name' => 'Иван Петров',
            'body' => 'Отличная статья про Eloquent! Очень подробно описаны связи.',
        ]);

        $post1->comments()->create([
            'user_id' => null,
            'author_name' => 'Гость_99',
            'body' => 'Полиморфные комментарии работают просто великолепно!',
        ]);

        $post2->comments()->create([
            'user_id' => $author->id,
            'author_name' => 'Мария Сидорова',
            'body' => 'API Resources сильно упрощают форматирование данных для фронтенда.',
        ]);

        // Полиморфный комментарий к категории
        $catLaravel->comments()->create([
            'user_id' => $author->id,
            'author_name' => 'Модератор',
            'body' => 'В этой категории собраны все лучшие материалы по Laravel.',
        ]);
    }
}
