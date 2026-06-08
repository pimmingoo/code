<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('profile page requires auth', function () {
    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});

test('profile page can be rendered', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('profile.edit'))->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'first_name' => 'Grace',
        'last_name' => 'Hopper',
        'email' => 'grace@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'));

    $user->refresh();
    expect($user->first_name)->toBe('Grace');
    expect($user->last_name)->toBe('Hopper');
    expect($user->email)->toBe('grace@example.com');
});

test('avatar can be uploaded and removed', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $this->actingAs($user)->patch(route('profile.update'), [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ])->assertRedirect(route('profile.edit'));

    $user->refresh();
    expect($user->avatar)->not->toBeNull();
    Storage::disk('public')->assertExists($user->avatar);

    $oldPath = $user->avatar;

    $this->actingAs($user)->patch(route('profile.update'), [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'remove_avatar' => '1',
    ])->assertRedirect(route('profile.edit'));

    $user->refresh();
    expect($user->avatar)->toBeNull();
    Storage::disk('public')->assertMissing($oldPath);
});

test('password can be updated with correct current password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $response = $this->actingAs($user)->put(route('profile.password'), [
        'current_password' => 'old-password',
        'password' => 'NewPassword123!',
        'password_confirmation' => 'NewPassword123!',
    ]);

    $response->assertRedirect(route('profile.edit'));
    expect(Hash::check('NewPassword123!', $user->fresh()->password))->toBeTrue();
});

test('password update fails with wrong current password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->from(route('profile.edit'))->put(route('profile.password'), [
        'current_password' => 'wrong-password',
        'password' => 'NewPassword123!',
        'password_confirmation' => 'NewPassword123!',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHasErrors('current_password');
});
