<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $latestRecipes = Recipe::with('user')
            ->latest()
            ->take(6)
            ->get();

        $popularTags = Tag::has('recipes')
            ->withCount('recipes')
            ->orderByDesc('recipes_count')
            ->take(8)
            ->get();

        return view('home', [
            'latestRecipes' => $latestRecipes,
            'popularTags' => $popularTags,
        ]);
    }
}
