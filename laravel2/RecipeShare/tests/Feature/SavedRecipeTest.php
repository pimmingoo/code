<?php

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot save recipes', function () {
    $recipe = Recipe::factory()->create();

    $this->post(route('recipes.save', $recipe))->assertRedirect(route('login'));
});

test('a user can save a recipe', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $this->actingAs($user)
        ->from(route('recipes.show', $recipe))
        ->post(route('recipes.save', $recipe))
        ->assertRedirect(route('recipes.show', $recipe));

    expect($recipe->isSavedBy($user))->toBeTrue();
});

test('saving the same recipe twice toggles it off', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $this->actingAs($user)->post(route('recipes.save', $recipe));
    $this->actingAs($user)->post(route('recipes.save', $recipe));

    expect($recipe->isSavedBy($user))->toBeFalse();
});

test('saved recipes page requires auth', function () {
    $this->get(route('saved-recipes.index'))->assertRedirect(route('login'));
});

test('saved recipes page lists the users saved recipes', function () {
    $user = User::factory()->create();
    $saved = Recipe::factory()->create(['title' => 'Saved Pie']);
    $other = Recipe::factory()->create(['title' => 'Not Saved']);
    $user->savedRecipes()->attach($saved);

    $this->actingAs($user)
        ->get(route('saved-recipes.index'))
        ->assertOk()
        ->assertSeeText('Saved Pie')
        ->assertDontSeeText('Not Saved');
});

test('saved recipes page shows empty state when nothing saved', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('saved-recipes.index'))
        ->assertOk()
        ->assertSeeText('No saved recipes yet');
});

test('saved recipes can be searched by title', function () {
    $user = User::factory()->create();
    $apple = Recipe::factory()->create(['title' => 'Apple Pie']);
    $banana = Recipe::factory()->create(['title' => 'Banana Bread']);
    $user->savedRecipes()->attach([$apple->id, $banana->id]);

    $this->actingAs($user)
        ->get(route('saved-recipes.index', ['q' => 'apple']))
        ->assertOk()
        ->assertSeeText('Apple Pie')
        ->assertDontSeeText('Banana Bread');
});

test('saved recipes can be searched by description', function () {
    $user = User::factory()->create();
    $match = Recipe::factory()->create(['title' => 'Mystery', 'description' => 'Loaded with turmeric.']);
    $nope = Recipe::factory()->create(['title' => 'Other', 'description' => 'Plain stuff.']);
    $user->savedRecipes()->attach([$match->id, $nope->id]);

    $this->actingAs($user)
        ->get(route('saved-recipes.index', ['q' => 'turmeric']))
        ->assertOk()
        ->assertSeeText('Mystery')
        ->assertDontSeeText('Other');
});

test('search on saved recipes ignores recipes the user did not save', function () {
    $user = User::factory()->create();
    $saved = Recipe::factory()->create(['title' => 'Saved Apple Tart']);
    Recipe::factory()->create(['title' => 'Public Apple Crumble']);
    $user->savedRecipes()->attach($saved);

    $this->actingAs($user)
        ->get(route('saved-recipes.index', ['q' => 'apple']))
        ->assertOk()
        ->assertSeeText('Saved Apple Tart')
        ->assertDontSeeText('Public Apple Crumble');
});

test('search shows match-specific empty state', function () {
    $user = User::factory()->create();
    $user->savedRecipes()->attach(Recipe::factory()->create(['title' => 'Apple Pie']));

    $this->actingAs($user)
        ->get(route('saved-recipes.index', ['q' => 'nothing-matches']))
        ->assertOk()
        ->assertSeeText('No matches');
});

test('saved recipes can be filtered by tag', function () {
    $user = User::factory()->create();
    $vegan = Tag::create(['name' => 'Vegan', 'slug' => 'vegan']);

    $veggie = Recipe::factory()->create(['title' => 'Veggie Bowl']);
    $veggie->tags()->attach($vegan);
    $steak = Recipe::factory()->create(['title' => 'Steak Dinner']);
    $user->savedRecipes()->attach([$veggie->id, $steak->id]);

    $this->actingAs($user)
        ->get(route('saved-recipes.index', ['tag' => 'vegan']))
        ->assertOk()
        ->assertSeeText('Veggie Bowl')
        ->assertDontSeeText('Steak Dinner');
});

test('tag filter list only includes tags from the users saved recipes', function () {
    $user = User::factory()->create();
    $vegan = Tag::create(['name' => 'Vegan', 'slug' => 'vegan']);
    $dessert = Tag::create(['name' => 'Dessert', 'slug' => 'dessert']);

    $saved = Recipe::factory()->create();
    $saved->tags()->attach($vegan);
    $user->savedRecipes()->attach($saved);

    // Another recipe with a tag the user has NOT saved
    $unsaved = Recipe::factory()->create();
    $unsaved->tags()->attach($dessert);

    $this->actingAs($user)
        ->get(route('saved-recipes.index'))
        ->assertOk()
        ->assertSeeText('Vegan')
        ->assertDontSeeText('Dessert');
});

test('tag and search filters combine', function () {
    $user = User::factory()->create();
    $vegan = Tag::create(['name' => 'Vegan', 'slug' => 'vegan']);

    $bowl = Recipe::factory()->create(['title' => 'Veggie Bowl']);
    $bowl->tags()->attach($vegan);
    $burger = Recipe::factory()->create(['title' => 'Veggie Burger']);
    $burger->tags()->attach($vegan);
    $user->savedRecipes()->attach([$bowl->id, $burger->id]);

    $this->actingAs($user)
        ->get(route('saved-recipes.index', ['tag' => 'vegan', 'q' => 'bowl']))
        ->assertOk()
        ->assertSeeText('Veggie Bowl')
        ->assertDontSeeText('Veggie Burger');
});
