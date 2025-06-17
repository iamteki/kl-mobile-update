<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/events/{slug}', [EventController::class, 'showByType'])->name('events.byType');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Location Pages
Route::get('/locations/corporate-office', [LocationController::class, 'corporateOffice'])->name('locations.corporate');
Route::get('/locations/warehouse', [LocationController::class, 'warehouse'])->name('locations.warehouse');