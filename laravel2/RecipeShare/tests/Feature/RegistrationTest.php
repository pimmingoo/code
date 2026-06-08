<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $this->get(route('register'))->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'email' => 'ada@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('home'));

    expect(User::where('email', 'ada@example.com')->exists())->toBeTrue();
});

test('registration requires matching password confirmation', function () {
    $response = $this->from(route('register'))->post(route('register.store'), [
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'email' => 'ada@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'different',
    ]);

    $response->assertRedirect(route('register'));
    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});
