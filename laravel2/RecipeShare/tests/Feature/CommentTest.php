<?php

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot post comments', function () {
    $recipe = Recipe::factory()->create();

    $this->post(route('comments.store', $recipe), ['body' => 'hi'])
        ->assertRedirect(route('login'));
});

test('an authenticated user can post a comment', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $this->actingAs($user)
        ->post(route('comments.store', $recipe), ['body' => 'Made this last night, loved it!'])
        ->assertRedirect();

    expect($recipe->comments()->count())->toBe(1);
    expect($recipe->comments()->first()->body)->toBe('Made this last night, loved it!');
    expect($recipe->comments()->first()->user_id)->toBe($user->id);
});

test('comment body is required', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $this->actingAs($user)
        ->from(route('recipes.show', $recipe))
        ->post(route('comments.store', $recipe), ['body' => ''])
        ->assertSessionHasErrors('body');
});

test('comments appear on the recipe show page', function () {
    $user = User::factory()->create(['first_name' => 'Ada', 'last_name' => 'Lovelace']);
    $recipe = Recipe::factory()->create();
    $recipe->comments()->create(['user_id' => $user->id, 'body' => 'Hello world']);

    $this->get(route('recipes.show', $recipe))
        ->assertOk()
        ->assertSeeText('Hello world')
        ->assertSeeText('Ada Lovelace');
});

test('a user can delete their own comment', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $comment = $recipe->comments()->create(['user_id' => $user->id, 'body' => 'oops']);

    $this->actingAs($user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect();

    expect(Comment::find($comment->id))->toBeNull();
});

test('a user cannot delete someone elses comment', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $recipe = Recipe::factory()->create();
    $comment = $recipe->comments()->create(['user_id' => $owner->id, 'body' => 'mine']);

    $this->actingAs($other)
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();

    expect(Comment::find($comment->id))->not->toBeNull();
});
