<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GroupController;
use App\Models\Group;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
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
    return Redirect::route('group.index'); 
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Redirect::route('group.index'); 
})->name('dashboard');

Route::get('/groups', [GroupController::class, 'index'])->name('group.index');

Route::post('/groups/search', [GroupController::class, 'search'])->name('group.search');

Route::middleware(['auth'])->name('group.')->group(function (){

    Route::post('/groups', [GroupController::class, 'store'])->name('store');
    
    Route::get('/groups/create', [GroupController::class, 'create'])->name('create');
    
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('update');
    
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('destroy');

    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('show');

    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('edit');

    Route::get('/groups/{group}/join', [GroupController::class, 'join'])->name('join');
});

Route::post('/messages', [MessageController::class, 'store']);

Route::middleware(['auth'])->name('schedule.')->group(function (){
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('index');
    
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('store');

    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('update');

    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
});