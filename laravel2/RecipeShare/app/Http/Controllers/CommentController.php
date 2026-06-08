<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function store(Request $request, Recipe $recipe): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        $recipe->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect()->route('recipes.show', $recipe)->withFragment('comments');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user && ($comment->user_id === $user->id || $user->isAdmin()), Response::HTTP_FORBIDDEN);

        $recipe = $comment->recipe;
        $comment->delete();

        return redirect()->route('recipes.show', $recipe)->withFragment('comments');
    }
}
