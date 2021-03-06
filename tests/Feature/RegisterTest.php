<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test */
    public function can_register()
    {
        $this->postJson('/api/register', [
            'name' => 'Test User',
            'username' => 'test@test.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
        ->assertSuccessful()
        ->assertJsonStructure(['token', 'token_type']);
    }

    /** @test */
    public function can_not_register_with_existing_username()
    {
        factory(User::class)->create(['username' => 'test@test.app']);

        $this->postJson('/api/register', [
            'name' => 'Test User',
            'username' => 'test@test.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['username']);
    }
}
