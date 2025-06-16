<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/events/{slug}', [EventController::class, 'showByType'])->name('events.byType');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show'); // New route for single event


// Add these routes to your web.php file:

// Location Pages
Route::get('/locations/corporate-office', [LocationController::class, 'corporateOffice'])->name('locations.corporate');
Route::get('/locations/warehouse', [LocationController::class, 'warehouse'])->name('locations.warehouse');