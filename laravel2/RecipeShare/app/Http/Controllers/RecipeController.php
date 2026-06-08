<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $tagSlug = trim((string) $request->query('tag', ''));

        $recipes = Recipe::query()
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
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $tags = Tag::has('recipes')
            ->withCount('recipes')
            ->orderBy('name')
            ->get();

        $activeTag = $tagSlug !== '' ? Tag::where('slug', $tagSlug)->first() : null;

        return view('recipes.index', [
            'recipes' => $recipes,
            'tags' => $tags,
            'search' => $search,
            'activeTag' => $activeTag,
        ]);
    }

    public function myRecipes(): View
    {
        $recipes = Auth::user()
            ->recipes()
            ->withCount('ingredients')
            ->latest()
            ->get();

        return view('recipes.my', ['recipes' => $recipes]);
    }

    public function create(): View
    {
        return view('recipes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRecipe($request);

        $recipe = $request->user()->recipes()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'prep_time' => $validated['prep_time'],
            'cook_time' => $validated['cook_time'],
            'servings' => $validated['servings'],
            'image' => $request->hasFile('image')
                ? $request->file('image')->store('recipes', 'public')
                : null,
        ]);

        $this->syncIngredients($recipe, $validated['ingredients']);
        $this->syncTags($recipe, $request->input('tags', ''));

        return redirect()->route('recipes.show', $recipe)->with('status', 'recipe-created');
    }

    public function show(Recipe $recipe): View
    {
        $recipe->load(['user', 'ingredients', 'tags', 'comments.user']);
        $recipe->loadCount(['likers', 'savers', 'comments']);

        return view('recipes.show', ['recipe' => $recipe]);
    }

    public function edit(Recipe $recipe): View
    {
        $this->authorizeOwner($recipe);

        $recipe->load(['ingredients', 'tags']);

        return view('recipes.edit', ['recipe' => $recipe]);
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $this->authorizeOwner($recipe);

        $validated = $this->validateRecipe($request);

        if ($request->boolean('remove_image') && $recipe->image) {
            Storage::disk('public')->delete($recipe->image);
            $recipe->image = null;
        }

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->image = $request->file('image')->store('recipes', 'public');
        }

        $recipe->fill([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'prep_time' => $validated['prep_time'],
            'cook_time' => $validated['cook_time'],
            'servings' => $validated['servings'],
        ])->save();

        $recipe->ingredients()->delete();
        $this->syncIngredients($recipe, $validated['ingredients']);
        $this->syncTags($recipe, $request->input('tags', ''));

        return redirect()->route('recipes.show', $recipe)->with('status', 'recipe-updated');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        $this->authorizeOwnerOrAdmin($recipe);

        $isOwner = $recipe->user_id === Auth::id();

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()
            ->route($isOwner ? 'recipes.my' : 'recipes.index')
            ->with('status', 'recipe-deleted');
    }

    /**
     * @return array{title: string, description: string, prep_time: int, cook_time: int, servings: int, ingredients: array<int, array{name: string, amount: string, unit: string}>}
     */
    private function validateRecipe(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'prep_time' => ['required', 'integer', 'min:0', 'max:1440'],
            'cook_time' => ['required', 'integer', 'min:0', 'max:1440'],
            'servings' => ['required', 'integer', 'min:1', 'max:100'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.name' => ['required', 'string', 'max:255'],
            'ingredients.*.amount' => ['required', 'string', 'max:50'],
            'ingredients.*.unit' => ['required', 'string', 'max:50'],
            'tags' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * @param  array<int, array{name: string, amount: string, unit: string}>  $ingredients
     */
    private function syncIngredients(Recipe $recipe, array $ingredients): void
    {
        foreach ($ingredients as $ingredient) {
            $recipe->ingredients()->create([
                'name' => $ingredient['name'],
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
            ]);
        }
    }

    private function syncTags(Recipe $recipe, ?string $tagsInput): void
    {
        $names = collect(explode(',', (string) $tagsInput))
            ->map(fn (string $name): string => trim($name))
            ->filter()
            ->unique(fn (string $name): string => Str::lower($name))
            ->values();

        $tagIds = $names->map(function (string $name): int {
            $slug = Str::slug($name);

            return Tag::firstOrCreate(['slug' => $slug], ['name' => $name])->id;
        });

        $recipe->tags()->sync($tagIds);
    }

    private function authorizeOwner(Recipe $recipe): void
    {
        abort_unless($recipe->user_id === Auth::id(), Response::HTTP_FORBIDDEN);
    }

    private function authorizeOwnerOrAdmin(Recipe $recipe): void
    {
        $user = Auth::user();
        abort_unless($user && ($recipe->user_id === $user->id || $user->isAdmin()), Response::HTTP_FORBIDDEN);
    }
}
