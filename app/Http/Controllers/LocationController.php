<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\OfficeLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display the corporate office location page.
     */
    // public function show()
    // {
    //     return view('location.index');
    // }
    public function show(OfficeLocation $location)
    {
        // Make sure the location is active
        if (!$location->is_active) {
            abort(404);
        }

        // Get team members assigned to this location
        $teamMembers = $location->teamMembers()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $faqs = Faq::active()
            ->ordered()
            ->get();

        return view('location.index', compact('location', 'teamMembers', 'faqs'));
    }
}
