<?php

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use Database\Seeders\RecipeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('isAdmin returns false by default', function () {
    $user = User::factory()->create();
    expect($user->isAdmin())->toBeFalse();
});

test('admin factory state marks user as admin', function () {
    $admin = User::factory()->admin()->create();
    expect($admin->isAdmin())->toBeTrue();
});

test('an admin can delete any recipe', function () {
    $admin = User::factory()->admin()->create();
    $owner = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($admin)
        ->delete(route('recipes.destroy', $recipe))
        ->assertRedirect(route('recipes.index'));

    expect(Recipe::find($recipe->id))->toBeNull();
});

test('owner deleting their own recipe still lands on my recipes', function () {
    $owner = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($owner)
        ->delete(route('recipes.destroy', $recipe))
        ->assertRedirect(route('recipes.my'));
});

test('an admin cannot edit recipes they do not own', function () {
    $admin = User::factory()->admin()->create();
    $owner = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($admin)
        ->get(route('recipes.edit', $recipe))
        ->assertForbidden();
});

test('an admin can delete any comment', function () {
    $admin = User::factory()->admin()->create();
    $author = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $comment = $recipe->comments()->create(['user_id' => $author->id, 'body' => 'hello']);

    $this->actingAs($admin)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect();

    expect(Comment::find($comment->id))->toBeNull();
});

test('a non-admin regular user still cannot delete other recipes', function () {
    $user = User::factory()->create();
    $owner = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($user)
        ->delete(route('recipes.destroy', $recipe))
        ->assertForbidden();

    expect(Recipe::find($recipe->id))->not->toBeNull();
});

test('seeder produces recipes owned by the admin user', function () {
    $this->seed(RecipeSeeder::class);

    $admin = User::where('email', 'admin@recipeshare.test')->first();
    expect($admin)->not->toBeNull();
    expect($admin->isAdmin())->toBeTrue();
    expect(Recipe::count())->toBeGreaterThan(5);
    expect(Recipe::whereNot('user_id', $admin->id)->count())->toBe(0);
});
