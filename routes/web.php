<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/events/{slug}', [EventController::class, 'showByType'])->name('events.byType');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show'); // New route for single event
