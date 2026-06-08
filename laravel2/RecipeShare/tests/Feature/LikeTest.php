<?php

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot like recipes', function () {
    $recipe = Recipe::factory()->create();

    $this->post(route('recipes.like', $recipe))->assertRedirect(route('login'));
});

test('a user can like a recipe', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $this->actingAs($user)
        ->from(route('recipes.show', $recipe))
        ->post(route('recipes.like', $recipe))
        ->assertRedirect(route('recipes.show', $recipe));

    expect($recipe->isLikedBy($user))->toBeTrue();
    expect($recipe->likers()->count())->toBe(1);
});

test('liking the same recipe twice toggles it off', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $this->actingAs($user)->post(route('recipes.like', $recipe));
    $this->actingAs($user)->post(route('recipes.like', $recipe));

    expect($recipe->isLikedBy($user))->toBeFalse();
    expect($recipe->likers()->count())->toBe(0);
});

test('like count appears on the recipe show page', function () {
    $recipe = Recipe::factory()->create();
    $likers = User::factory()->count(3)->create();
    foreach ($likers as $u) {
        $recipe->likers()->attach($u);
    }

    $this->get(route('recipes.show', $recipe))
        ->assertOk()
        ->assertSeeText('3');
});
