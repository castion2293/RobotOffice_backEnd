<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $admin = create('App\Admin');

        $this->actingAs($admin, 'admin');
    }

    /** @test */
    public function an_admin_can_create_a_user()
    {
        $this->post('admin/employee', [
            'name' => 'jane',
            'email' => 'jane@example.com',
            'start' => '2017-10-10',
            'hours' => '56.0'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'jane',
            'email' => 'jane@example.com',
            'start_date' => '2017-10-10',
            'holiday_days' => 56.0,
            'holiday' => 56.0,
            'rest' => 0,
        ]);


    }

    /** @test */
//    public function a_admin_can_access_all_schedules()
//    {
//        $year = Carbon::now()->year;
//        $month = Carbon::now()->month;
//
//        $this->get('/admin')
//             ->assertSee($year);
////             ->assertSee($month);
//    }
}
