<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRestScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_create_a_rest()
    {
        $rest_hours = auth()->user()->rest;

        $this->post('/api/schedule', [
            'category' => 'Rest',
            'date' => '2018-04-29',
            'begin' => '18:30',
            'end' => '20:30',
            'reason' => '台北出差',
            'hours' => 2
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
            'date' => '2018-04-29',
            'action_type' => 'App\Rest'
        ]);

        $this->assertDatabaseHas('rests', [
            'begin' => '18:30',
            'end' => '20:30',
            'reason' => '台北出差',
            'hours' => 2,
        ]);

        $this->assertEquals(auth()->user()->rest, $rest_hours + 2);
    }

    /** @test */
    public function a_user_can_delete_a_rest()
    {
        $rest_hours = auth()->user()->rest;

        $rest = create('App\Rest', [
            'begin' => '18:30',
            'end' => '20:30',
            'reason' => '台北出差',
            'hours' => 2
        ]);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-29',
            'action_type' => 'App\Rest',
            'action_id' => $rest->id
        ]);

        $this->delete('/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-29',
            'action_type' => 'App\Rest'
        ]);

        $this->assertDatabaseMissing('rests', [
            'begin' => '18:30',
            'end' => '20:30',
            'reason' => '台北出差',
            'hours' => 2,
        ]);

        $this->assertEquals(auth()->user()->rest, $rest_hours - 2);
    }
}
