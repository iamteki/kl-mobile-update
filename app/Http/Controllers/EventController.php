<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function showByType($slug)
    {
        $event = EventType::where('slug', $slug)->firstOrFail();
        return view('events.index', compact('event'));
    }
}
