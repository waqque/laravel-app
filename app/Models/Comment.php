<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_name',
        'body',
        'commentable_id',
        'commentable_type',
    ];

    /**
     * Полиморфная связь MorphTo: комментарий может принадлежать посту, категории и т.д.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Связь BelongsTo: комментарий может быть оставлен зарегистрированным пользователем.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
