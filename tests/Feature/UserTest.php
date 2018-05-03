<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_reset_profile()
    {
        $this->json('post', '/api/reset/profile', [
            'name' => 'reset_name',
            'email' => 'email@example.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => 'reset_name',
            'email' => 'email@example.com'
        ]);
    }

    /** @test */
    public function a_user_can_reset_password()
    {
        $this->json('post', 'api/reset/password', [
            'old_password' => 'secret',
            'password' => 'newsecret',
            'password_confirmation' => 'newsecret',
        ])->assertStatus(200);

        $this->assertTrue(password_verify('newsecret', auth()->user()->password));
    }

    /** @test */
    public function wrong_original_password()
    {
        $this->expectExceptionMessage('舊密碼輸入錯誤');

        $this->json('post', 'api/reset/password', [
            'old_password' => 'secret2',
            'password' => 'newsecret',
            'password_confirmation' => 'newsecret',
        ])->assertStatus(404);
    }

    /** @test */
    public function password_not_matched()
    {
        $this->expectExceptionMessage('The given data was invalid.');

        $this->json('post', 'api/reset/password', [
            'old_password' => 'secret',
            'password' => 'newsecret1',
            'password_confirmation' => 'newsecret2',
        ])->assertStatus(404);
    }
}
