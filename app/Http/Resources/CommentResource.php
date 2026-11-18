<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'author_name' => $this->author_name,
            'body' => $this->body,
            'commentable_type' => class_basename($this->commentable_type),
            'commentable_id' => $this->commentable_id,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
