<?php

namespace Tests\Feature;

use App\Holiday;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateHolidayScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_create_a_事假()
    {
        $type = create('App\Type', ['type' => '事假']);

        $this->post('/api/schedule', [
            'category' => 'Holiday',
            'date' => '2018-04-19',
            'begin' => '08:30',
            'end' => '17:30',
            'type' => $type->type,
            'hours' => 8
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
            'date' => '2018-04-19',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'begin' => '08:30',
            'end' => '17:30',
            'hours' => 8,
        ]);

        $holiday_type = Holiday::find(1)->types()->first();
        $this->assertEquals($holiday_type->type, $type->type);
    }

    /** @test */
    public function a_user_can_create_a_病假()
    {
        $type = create('App\Type', ['type' => '病假']);

        $this->post('/api/schedule', [
            'category' => 'Holiday',
            'date' => '2018-04-20',
            'begin' => '08:30',
            'end' => '17:30',
            'type' => $type->type,
            'hours' => 8
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
            'date' => '2018-04-20',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'begin' => '08:30',
            'end' => '17:30',
            'hours' => 8,
        ]);

        $holiday_type = Holiday::find(1)->types()->first();
        $this->assertEquals($holiday_type->type, $type->type);
    }

    /** @test */
    public function a_user_can_create_a_特休()
    {
        $holiday_hours = auth()->user()->holiday;

        $type = create('App\Type', ['type' => '特休']);

        $this->post('/api/schedule', [
            'category' => 'Holiday',
            'date' => '2018-04-21',
            'begin' => '08:30',
            'end' => '17:30',
            'type' => $type->type,
            'hours' => 8
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
            'date' => '2018-04-21',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'begin' => '08:30',
            'end' => '17:30',
            'hours' => 8,
        ]);

        $holiday_type = Holiday::find(1)->types()->first();
        $this->assertEquals($holiday_type->type, $type->type);

        $this->assertEquals(auth()->user()->holiday, $holiday_hours - 8);
    }

    /** @test */
    public function a_user_can_create_a_補休()
    {
        $rest_hours = auth()->user()->rest;

        $type = create('App\Type', ['type' => '補休']);

        $this->post('/api/schedule', [
            'category' => 'Holiday',
            'date' => '2018-04-22',
            'begin' => '08:30',
            'end' => '17:30',
            'type' => $type->type,
            'hours' => 4
        ])->assertStatus(200);

        $this->assertDatabaseHas('schedules', [
            'date' => '2018-04-22',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'begin' => '08:30',
            'end' => '17:30',
            'hours' => 4,
        ]);

        $holiday_type = Holiday::find(1)->types()->first();
        $this->assertEquals($holiday_type->type, $type->type);

        $this->assertEquals(auth()->user()->rest, $rest_hours - 4);
    }

    /** @test */
    public function take_特休_cannot_less_than_特休_hours()
    {
        $this->expectExceptionMessage('剩餘的特休時數不足，請重新選擇時段');

        $user = create('App\User', [
            'email' => 'foo@example.com',
            'holiday' => 4
        ]);

        $this->signIn($user);

        $type = create('App\Type', ['type' => '特休']);

        $this->post('/api/schedule', [
            'category' => 'Holiday',
            'date' => '2018-04-18',
            'begin' => '08:30',
            'end' => '17:30',
            'type' => $type->type,
            'hours' => 8
        ])->assertStatus(400);
    }

    /** @test */
    public function take_補休_cannot_less_than_補休_hours()
    {
        $this->expectExceptionMessage('剩餘的補休時數不足，請重新選擇時段');

        $user = create('App\User', [
            'email' => 'foo@example.com',
            'rest' => 4
        ]);

        $this->signIn($user);

        $type = create('App\Type', ['type' => '補休']);

        $this->post('/api/schedule', [
            'category' => 'Holiday',
            'date' => '2018-04-19',
            'begin' => '08:30',
            'end' => '17:30',
            'type' => $type->type,
            'hours' => 8
        ])->assertStatus(400);
    }

    /** @test */
    public function a_user_can_delete_a_事假()
    {
        $type = create('App\Type', ['type' => '事假']);

        $holiday = create('App\Holiday', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $holiday->types()->attach($type->id);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday',
            'action_id' => $holiday->id
        ]);

        $this->delete('/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseMissing('holidays', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $this->assertDatabaseMissing('holiday_type', [
            'holiday_id' => $holiday->id,
            'type_id' => $type->id
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_病假()
    {
        $type = create('App\Type', ['type' => '病假']);

        $holiday = create('App\Holiday', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $holiday->types()->attach($type->id);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday',
            'action_id' => $holiday->id
        ]);

        $this->delete('/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseMissing('holidays', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $this->assertDatabaseMissing('holiday_type', [
            'holiday_id' => $holiday->id,
            'type_id' => $type->id
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_特休()
    {
        $user = create('App\User', [
            'email' => 'foo@example.com',
            'holiday' => 4
        ]);

        $this->signIn($user);

        $holiday_hours = auth()->user()->holiday;

        $type = create('App\Type', ['type' => '特休']);

        $holiday = create('App\Holiday', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $holiday->types()->attach($type->id);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday',
            'action_id' => $holiday->id
        ]);

        $this->delete('/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseMissing('holidays', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $this->assertDatabaseMissing('holiday_type', [
            'holiday_id' => $holiday->id,
            'type_id' => $type->id
        ]);

        $this->assertEquals(auth()->user()->holiday, $holiday_hours + 8);
    }

    /** @test */
    public function a_user_can_delete_a_補休()
    {
        $user = create('App\User', [
            'email' => 'foo@example.com',
            'rest' => 4
        ]);

        $this->signIn($user);

        $rest_hours = auth()->user()->rest;

        $type = create('App\Type', ['type' => '補休']);

        $holiday = create('App\Holiday', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $holiday->types()->attach($type->id);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday',
            'action_id' => $holiday->id
        ]);

        $this->delete('/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-30',
            'action_type' => 'App\Holiday'
        ]);

        $this->assertDatabaseMissing('holidays', [
            'begin' => '08:30',
            'end' => '19:30',
            'hours' => 8
        ]);

        $this->assertDatabaseMissing('holiday_type', [
            'holiday_id' => $holiday->id,
            'type_id' => $type->id
        ]);

        $this->assertEquals(auth()->user()->rest, $rest_hours + 8);
    }
}
