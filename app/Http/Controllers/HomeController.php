<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
         $eventTypes = EventType::where('status', true)->orderBy('order')->get();
        return view('home.index', compact('eventTypes'));
    }
}
