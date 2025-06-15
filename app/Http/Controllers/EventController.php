<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function showByType($slug)
    {
        $eventType = EventType::where('slug', $slug)->firstOrFail();

        $events = $eventType->events()->select('title', 'featured_image', 'slug')->get();

        return view('events.index', compact('eventType', 'events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        return view('single.index', compact('event'));
    }
}
