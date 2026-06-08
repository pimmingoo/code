<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SavedRecipeController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $search = trim((string) $request->query('q', ''));
        $tagSlug = trim((string) $request->query('tag', ''));

        $recipes = $user->savedRecipes()
            ->with('user')
            ->withCount('ingredients')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($tagSlug !== '', function ($query) use ($tagSlug) {
                $query->whereHas('tags', fn ($q) => $q->where('slug', $tagSlug));
            })
            ->orderByPivot('created_at', 'desc')
            ->get();

        // Tags that appear on at least one of this user's saved recipes,
        // with a count of how many saved recipes carry each tag.
        $tags = Tag::whereHas('recipes', fn ($q) => $q->whereIn('recipes.id', $user->savedRecipes()->select('recipes.id')))
            ->withCount(['recipes' => fn ($q) => $q->whereIn('recipes.id', $user->savedRecipes()->select('recipes.id'))])
            ->orderBy('name')
            ->get();

        $activeTag = $tagSlug !== '' ? Tag::where('slug', $tagSlug)->first() : null;

        return view('saved-recipes.index', [
            'recipes' => $recipes,
            'search' => $search,
            'tags' => $tags,
            'activeTag' => $activeTag,
        ]);
    }

    public function toggle(Request $request, Recipe $recipe): RedirectResponse
    {
        $request->user()->savedRecipes()->toggle($recipe->id);

        return back(fallback: route('recipes.show', $recipe));
    }
}
