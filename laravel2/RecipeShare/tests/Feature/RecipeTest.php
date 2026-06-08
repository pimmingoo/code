<?php

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('my recipes page requires auth', function () {
    $this->get(route('recipes.my'))->assertRedirect(route('login'));
});

test('my recipes page shows only the users own recipes', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Recipe::factory()->create(['user_id' => $user->id, 'title' => 'My Soup']);
    Recipe::factory()->create(['user_id' => $other->id, 'title' => 'Their Soup']);

    $response = $this->actingAs($user)->get(route('recipes.my'));

    $response->assertOk();
    $response->assertSeeText('My Soup');
    $response->assertDontSeeText('Their Soup');
});

test('create recipe form can be rendered', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('recipes.create'))->assertOk();
});

test('a recipe can be created with ingredients and tags', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('recipes.store'), [
        'title' => 'Tomato Soup',
        'description' => 'Warm and comforting.',
        'image' => UploadedFile::fake()->image('soup.jpg'),
        'prep_time' => 10,
        'cook_time' => 30,
        'servings' => 4,
        'ingredients' => [
            ['amount' => '2', 'unit' => 'cans', 'name' => 'tomatoes'],
            ['amount' => '1', 'unit' => 'tbsp', 'name' => 'olive oil'],
        ],
        'tags' => 'dinner, soup',
    ]);

    $recipe = Recipe::first();
    expect($recipe)->not->toBeNull();
    expect($recipe->title)->toBe('Tomato Soup');
    expect($recipe->user_id)->toBe($user->id);
    expect($recipe->ingredients)->toHaveCount(2);
    expect($recipe->tags->pluck('name')->all())->toEqualCanonicalizing(['dinner', 'soup']);
    Storage::disk('public')->assertExists($recipe->image);

    $response->assertRedirect(route('recipes.show', $recipe));
});

test('creating a recipe requires at least one ingredient', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->from(route('recipes.create'))->post(route('recipes.store'), [
        'title' => 'Bare',
        'description' => 'Nothing.',
        'prep_time' => 5,
        'cook_time' => 5,
        'servings' => 1,
        'ingredients' => [],
    ]);

    $response->assertRedirect(route('recipes.create'));
    $response->assertSessionHasErrors('ingredients');
});

test('tags are reused when the same slug already exists', function () {
    $user = User::factory()->create();
    Tag::create(['name' => 'Dinner', 'slug' => 'dinner']);

    $this->actingAs($user)->post(route('recipes.store'), [
        'title' => 'Stew',
        'description' => 'Hearty.',
        'prep_time' => 15,
        'cook_time' => 60,
        'servings' => 6,
        'ingredients' => [
            ['amount' => '500', 'unit' => 'g', 'name' => 'beef'],
        ],
        'tags' => 'dinner',
    ]);

    expect(Tag::count())->toBe(1);
    expect(Recipe::first()->tags)->toHaveCount(1);
});

test('users cannot edit other peoples recipes', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($other)->get(route('recipes.edit', $recipe))->assertForbidden();
    $this->actingAs($other)->patch(route('recipes.update', $recipe), [])->assertForbidden();
    $this->actingAs($other)->delete(route('recipes.destroy', $recipe))->assertForbidden();
});

test('a recipe can be updated by its owner', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $user->id, 'title' => 'Old Title']);
    $recipe->ingredients()->create(['name' => 'old', 'amount' => '1', 'unit' => 'cup']);

    $response = $this->actingAs($user)->patch(route('recipes.update', $recipe), [
        'title' => 'New Title',
        'description' => 'Updated.',
        'prep_time' => 5,
        'cook_time' => 10,
        'servings' => 2,
        'ingredients' => [
            ['amount' => '2', 'unit' => 'tbsp', 'name' => 'butter'],
        ],
        'tags' => '',
    ]);

    $response->assertRedirect(route('recipes.show', $recipe));
    $recipe->refresh()->load('ingredients');
    expect($recipe->title)->toBe('New Title');
    expect($recipe->ingredients)->toHaveCount(1);
    expect($recipe->ingredients->first()->name)->toBe('butter');
});

test('a recipe can be deleted by its owner', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'image' => UploadedFile::fake()->image('x.jpg')->store('recipes', 'public'),
    ]);
    $imagePath = $recipe->image;

    $response = $this->actingAs($user)->delete(route('recipes.destroy', $recipe));

    $response->assertRedirect(route('recipes.my'));
    expect(Recipe::find($recipe->id))->toBeNull();
    Storage::disk('public')->assertMissing($imagePath);
});

test('show page is publicly viewable', function () {
    $recipe = Recipe::factory()->create();
    $this->get(route('recipes.show', $recipe))->assertOk()->assertSeeText($recipe->title);
});
