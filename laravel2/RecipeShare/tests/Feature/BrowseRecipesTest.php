<?php

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('browse page is publicly viewable', function () {
    $this->get(route('recipes.index'))->assertOk();
});

test('browse page lists all recipes', function () {
    Recipe::factory()->create(['title' => 'Apple Pie']);
    Recipe::factory()->create(['title' => 'Banana Bread']);

    $this->get(route('recipes.index'))
        ->assertOk()
        ->assertSeeText('Apple Pie')
        ->assertSeeText('Banana Bread');
});

test('search filters recipes by title', function () {
    Recipe::factory()->create(['title' => 'Apple Pie']);
    Recipe::factory()->create(['title' => 'Banana Bread']);

    $this->get(route('recipes.index', ['q' => 'apple']))
        ->assertOk()
        ->assertSeeText('Apple Pie')
        ->assertDontSeeText('Banana Bread');
});

test('search filters recipes by description', function () {
    Recipe::factory()->create(['title' => 'Mystery Dish', 'description' => 'Made with secret ingredient: turmeric.']);
    Recipe::factory()->create(['title' => 'Other', 'description' => 'Nothing here.']);

    $this->get(route('recipes.index', ['q' => 'turmeric']))
        ->assertOk()
        ->assertSeeText('Mystery Dish')
        ->assertDontSeeText('Other');
});

test('tag filter shows only recipes with that tag', function () {
    $tag = Tag::create(['name' => 'Vegan', 'slug' => 'vegan']);

    $matching = Recipe::factory()->create(['title' => 'Veggie Bowl']);
    $matching->tags()->attach($tag);

    Recipe::factory()->create(['title' => 'Beef Stew']);

    $this->get(route('recipes.index', ['tag' => 'vegan']))
        ->assertOk()
        ->assertSeeText('Veggie Bowl')
        ->assertDontSeeText('Beef Stew');
});

test('browse shows empty state when no results', function () {
    Recipe::factory()->create(['title' => 'Apple Pie']);

    $this->get(route('recipes.index', ['q' => 'nonexistent-thing']))
        ->assertOk()
        ->assertSeeText('No recipes found');
});

test('browse paginates results', function () {
    Recipe::factory()->count(15)->create();

    $response = $this->get(route('recipes.index'))->assertOk();
    // Pagination renders Next link when there are more than 12 items
    $response->assertSee('Next');
});
