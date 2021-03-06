<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsercreateRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Http\Requests\UserResetProfileRequest;
use App\Transformers\Schedule\TransformerFactory;
use App\Transformers\Schedule\TransformerPresentAnalysis;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $data = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'start_date' => $user->start_date,
                'holidays' => $user->holiday_days,
                'holiday' => $user->holiday,
                'rest' => $user->rest
            ];
        });

        return view('employees', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employeeCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsercreateRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'start_date' => $request->start,
            'holiday_days' => $request->hours,
            'holiday' => $request->hours,
            'rest' => 0,
        ]);

        return redirect('/admin/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
       $user = User::whereName($name)->first();

       if (!!$user->schedules) {
           $presents = $user->schedules()->where('action_type', 'App\\Present')->get();
           $holidays = $user->schedules()->where('action_type', 'App\\Holiday')->get();
           $trips = $user->schedules()->where('action_type', 'App\\Trip')->get();
           $rests = $user->schedules()->where('action_type', 'App\\Rest')->get();

           return view('employeeShow', [
               'user' => $user,
               'presents' => TransformerFactory::create('PresentAnalysis')->transform($presents),
               'holidays' => TransformerFactory::create('HolidayAnalysis')->transform($holidays),
               'trips' => TransformerFactory::create('TripAnalysis')->transform($trips),
               'rests' => TransformerFactory::create('RestAnalysis')->transform($rests),
           ]);
       }

       return view('employeeShow', [
           'user' => $user,
           'presents' => TransformerFactory::create('PresentAnalysis')->transform(collect([])),
           'holidays' => TransformerFactory::create('HolidayAnalysis')->transform(collect([])),
           'trips' => TransformerFactory::create('TripAnalysis')->transform(collect([])),
           'rests' => TransformerFactory::create('RestAnalysis')->transform(collect([])),
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @param UserResetProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetUserProfile(UserResetProfileRequest $request)
    {
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response()->json(auth()->user());
    }

    public function resetUserPassword(UserResetPasswordRequest $request)
    {
        $user = auth()->user();

        if (password_verify($request->old_password, $user->password)) {
            $user->update([
                'password' =>  bcrypt($request->password)
            ]);

            return response()->json(auth()->user());
        } else {
//            return response()->json(['message' => '舊密碼輸入錯誤'], 404);
            abort(404, '舊密碼輸入錯誤');
        }
    }
}
