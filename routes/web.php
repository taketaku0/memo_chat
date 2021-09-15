<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GroupController;
use App\Models\Group;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth'])->name('group.')->group(function (){
    Route::get('/groups', [GroupController::class, 'index'])->name('index');

    Route::post('/groups', [GroupController::class, 'store'])->name('store');
    
    Route::get('/groups/create', [GroupController::class, 'create'])->name('create');
    
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('update');
    
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('destroy');

    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('show');

    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('edit');

    Route::get('/groups/{group}/join', [GroupController::class, 'join'])->name('join');
});

Route::post('/messages', [MessageController::class, 'store']);

Route::middleware(['auth'])->get('/schedules', [ScheduleController::class, 'show'])->name('schedule.show');

Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedule.store');