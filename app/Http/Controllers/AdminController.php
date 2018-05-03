<?php

namespace App\Http\Controllers;

use App\Filters\ScheduleFilters;
use App\Schedule;
use App\Transformers\Schedule\TransformerFactory;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ScheduleFilters $filters)
    {
        $schedules = Schedule::filter($filters)->get();

        if (request()->exists('method')) {
            $data = TransformerFactory::create(request('method'))->transform($schedules);
        }

        $year = request()->year;
        $month = request()->month;

        return view('admin', compact('data', 'year', 'month'));
    }
}
