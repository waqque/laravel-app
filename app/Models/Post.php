<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Поля, разрешенные для массового заполнения.
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'is_published',
        'views_count',
        'published_at',
    ];

    /**
     * Приведение типов атрибутов (Casts).
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'views_count' => 'integer',
            'published_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Связи (Relationships)
    |--------------------------------------------------------------------------
    */

    /**
     * Связь BelongsTo: пост принадлежит одной категории.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь BelongsTo: пост принадлежит автору (пользователю).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь BelongsToMany: пост может иметь множество тегов (многие-ко-многим).
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Полиморфная связь MorphMany: пост может иметь множество комментариев.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes (локальные области запросов)
    |--------------------------------------------------------------------------
    */

    /**
     * Scope: только опубликованные посты.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope: популярные посты с числом просмотров не менее $minViews.
     */
    public function scopePopular(Builder $query, int $minViews = 50): Builder
    {
        return $query->where('views_count', '>=', $minViews);
    }

    /**
     * Scope: фильтрация по категории.
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: поиск по заголовку или тексту.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('content', 'like', "%{$term}%");
        });
    }
}
