<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTripScheduleTest extends TestCase
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
        $this->json('post', '/api/schedule', [
            'category' => 'Trip',
            'date' => '2018-04-25',
            'begin' => '08:30',
            'end' => '17:30',
            'location' => '台北',
            'hours' => 9
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
            'date' => '2018-04-25',
            'action_type' => 'App\Trip'
        ]);

        $this->assertDatabaseHas('trips', [
            'begin' => '08:30',
            'end' => '17:30',
            'location' => '台北',
            'hours' => 9,
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_trip()
    {
        $trip = create('App\Trip', [
            'begin' => '08:30',
            'end' => '19:30',
            'location' => '台北',
            'hours' => 11
        ]);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-29',
            'action_type' => 'App\Trip',
            'action_id' => $trip->id
        ]);

        $this->json('delete', '/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-29',
            'action_type' => 'App\Trip'
        ]);

        $this->assertDatabaseMissing('trips', [
            'begin' => '08:30',
            'end' => '19:30',
            'location' => '台北',
            'hours' => 11,
        ]);
    }
}
