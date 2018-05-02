<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_schedule_can_have_a_present()
    {
        $schedule = create('App\Schedule', [
            'user_id' => 1,
            'date' => '2018-04-29',
            'action_type' => 'App\Present',
            'action_id' => create('App\Present', [
                'begin' => '08:30',
                'end' => '19:30'
            ])
        ]);

        $this->assertEquals($schedule->action->count(), 1);
    }

    /** @test */
    public function a_schedule_can_have_a_holiday()
    {
        $type = create('App\Type', ['type' => '特休']);

        $holiday = create('App\Holiday', [
            'begin' => '08:30:00',
            'end' => '17:30:00',
            'hours' => 8
        ]);

        $holiday->types()->attach($type->id);

        $schedule = create('App\Schedule', [
            'user_id' => 1,
            'date' => '2018-04-02',
            'action_type' => 'App\\Holiday',
            'action_id' => $holiday->id
        ]);

        $this->assertEquals($schedule->action->count(), 1);
    }

    /** @test */
    public function a_schedule_can_have_a_trip()
    {
        $schedule = create('App\Schedule', [
            'user_id' => 1,
            'date' => '2018-04-02',
            'action_type' => 'App\\Trip',
            'action_id' => create('App\Trip', [
                'begin' => '08:30:00',
                'end' => '17:30:00',
                'location' => '台北',
                'hours' => 9
            ]),
        ]);

        $this->assertEquals($schedule->action->count(), 1);
    }

    /** @test */
    public function a_schedule_can_have_a_rest()
    {
        $schedule = create('App\Schedule', [
            'user_id' => 1,
            'date' => '2018-04-02',
            'action_type' => 'App\\Rest',
            'action_id' => create('App\Rest', [
                'begin' => '18:30:00',
                'end' => '20:30:00',
                'reason' => '台北出差',
                'hours' => 2
            ]),
        ]);

        $this->assertEquals($schedule->action->count(), 1);
    }
}
