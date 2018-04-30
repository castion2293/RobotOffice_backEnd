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
    }
    
    /** @test */
//    public function a_admin_can_access_all_users()
//    {
//        $admin = create('App\Admin');
//
//        $user = create('App\User');
//
//        $this->actingAs($admin, 'admin');
//
//         = $this->get('/admin/employees');
//
//        dd($users);
//
//    }
}
