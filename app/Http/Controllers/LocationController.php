<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display the corporate office location page.
     */
    public function corporateOffice()
    {
        return view('location.index');
    }

    /**
     * Display the warehouse location page.
     */
    public function warehouse()
    {
        // You can create a similar page for warehouse
        return view('location.warehouse');
    }
}