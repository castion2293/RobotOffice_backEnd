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
    public function a_user_can_create_a_trip()
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
}
