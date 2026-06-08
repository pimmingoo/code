<?php

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page renders for guests', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSeeText('Cook, share, discover')
        ->assertSeeText('Join RecipeShare');
});

test('home page shows latest recipes', function () {
    Recipe::factory()->count(3)->create();
    $featured = Recipe::factory()->create(['title' => 'Pancakes Supreme']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSeeText('Pancakes Supreme');
});

test('home page shows popular tags ordered by recipe count', function () {
    $dinner = Tag::create(['name' => 'Dinner', 'slug' => 'dinner']);
    $rare = Tag::create(['name' => 'Rare', 'slug' => 'rare']);

    Recipe::factory()->count(3)->create()->each(fn ($r) => $r->tags()->attach($dinner));
    Recipe::factory()->create()->tags()->attach($rare);

    $response = $this->get(route('home'))->assertOk();
    $response->assertSeeText('Dinner');
    $response->assertSeeText('Rare');
    // Dinner should appear before Rare (3 recipes vs 1)
    expect(strpos($response->getContent(), 'Dinner'))
        ->toBeLessThan(strpos($response->getContent(), 'Rare'));
});

test('home page hides tags with no recipes', function () {
    Tag::create(['name' => 'Empty', 'slug' => 'empty']);

    $this->get(route('home'))
        ->assertOk()
        ->assertDontSeeText('Empty');
});

test('logged-in users see add recipe CTA instead of register', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertSeeText('Add a recipe')
        ->assertDontSeeText('Join RecipeShare');
});
