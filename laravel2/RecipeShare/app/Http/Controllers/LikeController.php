<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Recipe $recipe): RedirectResponse
    {
        $request->user()->likedRecipes()->toggle($recipe->id);

        return back(fallback: route('recipes.show', $recipe));
    }
}
