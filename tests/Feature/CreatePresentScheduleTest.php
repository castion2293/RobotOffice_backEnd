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
        $this->json('POST', '/api/schedule', [
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
        $this->expectExceptionMessage('重複打卡上班，請先刪除之前打卡紀錄，再重新打卡上班');

        $present = create('App\Present', ['begin' => '08:30']);
        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-20',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->json('POST','/api/schedule', [
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

        $this->json('POST', '/api/schedule', [
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
        $this->expectExceptionMessage('打卡下班前，需先打卡上班');

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
        $this->expectExceptionMessage('重複打卡下班，請先刪除之前打卡紀錄，再重新打卡下班');

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
        $this->expectExceptionMessage('打卡下班時間需晚於打卡上班時間');

        $present = create('App\Present', ['begin' => '08:30']);
        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-23',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->json('POST', '/api/schedule', [
            'category' => 'Present',
            'work' => '下班',
            'date' => '2018-04-23',
            'time' => '07:30'
        ])->assertStatus(400);
    }

    /** @test */
    public function a_user_can_delete_a_present_schedule()
    {
        $present = create('App\Present', [
            'begin' => '08:30',
            'end' => '19:30'
        ]);

        $schedule = create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-29',
            'action_type' => 'App\Present',
            'action_id' => $present->id
        ]);

        $this->json('delete', '/api/schedule/' . $schedule->id)->assertStatus(200);

        $this->assertDatabaseMissing('schedules', [
            'date' => '2018-04-29',
            'action_type' => 'App\Present'
        ]);

        $this->assertDatabaseMissing('presents', [
            'begin' => '08:30',
            'end' => '19:30'
        ]);
    }
}
