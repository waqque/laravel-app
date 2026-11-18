<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_published' => (bool) $this->is_published,
            'views_count' => (int) $this->views_count,
            'published_at' => $this->published_at?->toIso8601String(),
            'is_deleted' => $this->trashed(),
            'deleted_at' => $this->deleted_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),

            // Вложенные связи (BelongsTo, BelongsToMany, MorphMany)
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'comments_count' => $this->comments_count ?? $this->comments()->count(),
        ];
    }
}
