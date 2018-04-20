<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresentScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_create_a_present_schedule()
    {
        $this->signIn();

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
        $this->signIn();

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
}
