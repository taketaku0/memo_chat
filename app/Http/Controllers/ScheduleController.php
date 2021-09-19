<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
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

    public function update(Request $request, Schedule $schedule)
    {
        $schedule->update([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'user_id' => $request->user_id
        ]);

        return $schedule;
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response(null, 204);  
    }
}
