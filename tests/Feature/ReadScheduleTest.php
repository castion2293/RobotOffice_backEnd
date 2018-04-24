<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadScheduleTest extends TestCase
{
//    use RefreshDatabase;
//
//    public function setUp()
//    {
//        parent::setUp();
//
//        $this->signIn();
//
//        $this->prepareDatabase();
//    }
//
//    /** @test */
//    public function a_user_can_read_all_schedule()
//    {
//        $response = $this->get('/api/schedule?month=4');
////                        ->assertJson([
////                            ['title' => 'App\Holiday']
////                        ]);
//
//        dd($response);
//    }
//
//    private function prepareDatabase(): void
//    {
//        $present = create('App\Present', [
//            'begin' => '08:30:00',
//            'end' => '17:30:00'
//        ]);
//
////        $holiday = create('App\Holiday', [
////            'begin' => '08:30:00',
////            'end' => '17:30:00',
////            'hours' => 8
////        ]);
////
////        $trip = create('App\Trip', [
////            'begin' => '08:30:00',
////            'end' => '17:30:00',
////            'hours' => 9
////        ]);
////
////        $rest = create('App\Rest', [
////            'begin' => '18:30:00',
////            'end' => '20:30:00',
////            'hours' => 2
////        ]);
//
//        $schedule = create('App\Schedule', [
//            'user_id' => auth()->id(),
//            'date' => Carbon::parse('2018-04-02')->toDateString(),
//            'action_type' => 'App\\Present',
//            'action_id' => $present->id
//        ]);
//
////        create('App\Schedule', [
////            'user_id' => auth()->id(),
////            'date' => '2018-04-02',
////            'action_type' => 'App\\Holiday',
////            'action_id' => $holiday->id
////        ]);
////
////        create('App\Schedule', [
////            'user_id' => auth()->id(),
////            'date' => '2018-04-03',
////            'action_type' => 'App\\Trip',
////            'action_id' => $trip->id
////        ]);
////
////        create('App\Schedule', [
////            'user_id' => auth()->id(),
////            'date' => '2018-04-04',
////            'action_type' => 'App\\Rest',
////            'action_id' => $rest->id
////        ]);
    //}
}
