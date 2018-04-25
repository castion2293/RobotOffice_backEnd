<?php

namespace App\Http\Controllers;

use App\Filters\ScheduleFilters;
use App\Present;
use App\Schedule;
use App\Services\Schedule\ScheduleFactoryService;

use App\Transformers\Schedule\TransformerFactory;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * @var ScheduleTransformer
     */
//    protected $transformer;
//
//    public function __construct(ScheduleTransformer $transformer)
//    {
//        $this->transformer = $transformer;
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ScheduleFilters $filters)
    {
        $schedules = Schedule::filter($filters)->get();
//dd($schedules);
        if (request()->exists('method')) {
            return TransformerFactory::create(request('method'))->transform($schedules);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return ScheduleFactoryService::create($request->category)->post($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $type = str_replace('App\\', '', $schedule->action_type);

        return ScheduleFactoryService::create($type)->delete($schedule);
    }
}
