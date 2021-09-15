<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ScheduleController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return Inertia::render('Schedule', [
            'schedules' => $user->schedules,
            'user_id' => Auth::id()
        ]);
    }

    public function store(Request $request)
    {
        $schedule = new Schedule;
        $schedule->title = $request->title;
        $schedule->description = $request->description;
        $schedule->start = $request->start;
        $schedule->end = $request->end;
        $schedule->user_id = $request->user_id;
        $schedule->save();

        return $schedule;
    }
}
