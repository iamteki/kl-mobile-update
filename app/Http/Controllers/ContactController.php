<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Models\EventType;
use App\Mail\ContactInquiryMail;
use App\Mail\ContactConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'service' => 'nullable|string',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // Prepare data for storage
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            // Handle service/event type
            if (!empty($validated['service'])) {
                if ($validated['service'] === 'other') {
                    $data['service'] = 'other';
                } else {
                    $data['event_type_id'] = $validated['service'];
                }
            }

            // Create the inquiry
            $inquiry = ContactInquiry::create($data);

            // Send email to admin
            Mail::to(config('mail.from.address'))
                ->send(new ContactInquiryMail($inquiry));

            // Send confirmation email to user
            Mail::to($inquiry->email)
                ->send(new ContactConfirmationMail($inquiry));

            // Return success response
            return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');

        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form submission error: ' . $e->getMessage(), [
                'data' => $validated,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return error response
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Sorry, there was an error sending your message. Please try again later.']);
        }
    }
}