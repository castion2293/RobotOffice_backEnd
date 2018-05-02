<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_read_one_year_schedule_for_present()
    {
        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-02',
            'action_type' => 'App\\Present',
            'action_id' => create('App\Present', [
                                'begin' => '08:30:00',
                                'end' => '17:30:00'
                            ])->id
        ]);

        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-03',
            'action_type' => 'App\\Present',
            'action_id' => create('App\Present', [
                'begin' => '08:35:00',
                'end' => '17:39:00'
            ])->id
        ]);

        $this->json('get','/api/schedule?year=2018&type=Present&method=PresentAnalysis')
                ->assertJson([
                    'data' => [
                        [
                            'date' => '2018-04-02',
                            'begin' => '08:30:00',
                            'end' => '17:30:00'
                        ],
                        [
                            'date' => '2018-04-03',
                            'begin' => '08:35:00',
                            'end' => '17:39:00'
                        ],
                    ],
                    'count' => 2
                ]);
    }

    /** @test */
    public function a_user_can_read_one_year_schedule_for_holiday()
    {
        $type1 = create('App\Type', ['type' => '事假']);
        $type2 = create('App\Type', ['type' => '特休']);

        $holiday1 = create('App\Holiday', [
            'begin' => '08:30:00',
            'end' => '17:30:00',
            'hours' => 8
        ]);

        $holiday2 = create('App\Holiday', [
            'begin' => '13:30:00',
            'end' => '17:30:00',
            'hours' => 4
        ]);

        $holiday1->types()->attach($type1->id);
        $holiday2->types()->attach($type2->id);

        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-02',
            'action_type' => 'App\\Holiday',
            'action_id' => $holiday1->id
        ]);

        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-03',
            'action_type' => 'App\\Holiday',
            'action_id' => $holiday2->id
        ]);

        $this->json('get', '/api/schedule?year=2018&type=Holiday&method=HolidayAnalysis')
            ->assertJson([
                'data' => [
                    [
                        'date' => '2018-04-02',
                        'begin' => '08:30:00',
                        'end' => '17:30:00',
                        'type' => '事假',
                        'hours' => 8
                    ],
                    [
                        'date' => '2018-04-03',
                        'begin' => '13:30:00',
                        'end' => '17:30:00',
                        'type' => '特休',
                        'hours' => 4
                    ],
                ],
                'hours_count' => 12
            ]);
    }

    /** @test */
    public function a_user_can_read_one_year_schedule_for_trip()
    {
        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-02',
            'action_type' => 'App\\Trip',
            'action_id' => create('App\Trip', [
                'begin' => '08:30:00',
                'end' => '17:30:00',
                'location' => '台北',
                'hours' => 9
            ]),
        ]);

        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-03',
            'action_type' => 'App\\Trip',
            'action_id' => create('App\Trip', [
                'begin' => '13:30:00',
                'end' => '17:30:00',
                'location' => '高雄',
                'hours' => 4
            ]),
        ]);

        $this->json('get', '/api/schedule?year=2018&type=Trip&method=TripAnalysis')
            ->assertJson([
                'data' => [
                    [
                        'date' => '2018-04-02',
                        'begin' => '08:30:00',
                        'end' => '17:30:00',
                        'location' => '台北',
                        'hours' => 9
                    ],
                    [
                        'date' => '2018-04-03',
                        'begin' => '13:30:00',
                        'end' => '17:30:00',
                        'location' => '高雄',
                        'hours' => 4
                    ],
                ],
                'hours_count' => 13
            ]);
    }

    /** @test */
    public function a_user_can_read_one_year_schedule_for_rest()
    {
        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-02',
            'action_type' => 'App\\Rest',
            'action_id' => create('App\Rest', [
                'begin' => '18:30:00',
                'end' => '20:30:00',
                'reason' => '台北出差',
                'hours' => 2
            ]),
        ]);

        create('App\Schedule', [
            'user_id' => auth()->id(),
            'date' => '2018-04-03',
            'action_type' => 'App\\Rest',
            'action_id' => create('App\Rest', [
                'begin' => '18:30:00',
                'end' => '21:30:00',
                'reason' => '高雄出差',
                'hours' => 3
            ]),
        ]);

        $this->json('get', '/api/schedule?year=2018&type=Rest&method=RestAnalysis')
            ->assertJson([
                'data' => [
                    [
                        'date' => '2018-04-02',
                        'begin' => '18:30:00',
                        'end' => '20:30:00',
                        'reason' => '台北出差',
                        'hours' => 2
                    ],
                    [
                        'date' => '2018-04-03',
                        'begin' => '18:30:00',
                        'end' => '21:30:00',
                        'reason' => '高雄出差',
                        'hours' => 3
                    ],
                ],
                'hours_count' => 5
            ]);
    }
}
