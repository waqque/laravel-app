<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Добавление полиморфного комментария к посту.
     */
    public function storeForPost(Request $request, int $postId): RedirectResponse
    {
        $validated = $request->validate([
            'author_name' => 'required|string|min:2|max:100',
            'body' => 'required|string|min:3|max:1000',
        ]);

        $post = Post::withTrashed()->findOrFail($postId);

        // Полиморфное создание комментария через связь morphMany
        $post->comments()->create([
            'user_id' => 1,
            'author_name' => $validated['author_name'],
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Комментарий успешно добавлен (полиморфная связь MorphMany)!');
    }
}
