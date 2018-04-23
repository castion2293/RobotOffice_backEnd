<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePresentScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_create_a_present_schedule()
    {
        $this->post('/api/schedule', [
            'category' => 'Present',
            'work' => '上班',
            'date' => '2018-04-19',
            'time' => '08:30'
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
                'date' => '2018-04-19',
                'action_type' => 'App\Present'
            ]);

        $this->assertDatabaseHas('presents', [
            'begin' => '08:30'
        ]);
    }

    /** @test */
    public function a_user_cannot_create_another_present_in_same_day()
    {
        $present = create('App\Present', ['begin' => '08:30']);
        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-20',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->post('/api/schedule', [
            'category' => 'Present',
            'work' => '上班',
            'date' => '2018-04-20',
            'time' => '08:30'
        ])->assertStatus(400);
    }

    /** @test */
    public function a_user_can_create_off_present()
    {
        $present = create('App\Present', ['begin' => '08:30']);
        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-20',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->post('/api/schedule', [
            'category' => 'Present',
            'work' => '下班',
            'date' => '2018-04-20',
            'time' => '17:30'
        ])->assertStatus(200);

        $this->assertDatabaseHas('presents', [
            'end' => '17:30'
        ]);
    }

    /** @test */
    public function create_an_off_present_need_have_an_on_present()
    {
        $this->post('/api/schedule', [
            'category' => 'Present',
            'work' => '下班',
            'date' => '2018-04-20',
            'time' => '17:30'
        ])->assertStatus(400);
    }

    /** @test */
    public function a_user_cannot_create_another_off_present_in_same_day()
    {
        $present = create('App\Present', [
            'begin' => '08:30',
            'end' => '17:30',
        ]);
        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-22',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->post('/api/schedule', [
            'category' => 'Present',
            'work' => '下班',
            'date' => '2018-04-22',
            'time' => '18:30'
        ])->assertStatus(400);
    }

    /** @test */
    public function off_present_cannot_later_than_on_present()
    {
        $present = create('App\Present', ['begin' => '08:30']);
        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-23',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->post('/api/schedule', [
            'category' => 'Present',
            'work' => '下班',
            'date' => '2018-04-23',
            'time' => '07:30'
        ])->assertStatus(400);
    }
}
