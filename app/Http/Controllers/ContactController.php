<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Models\EventType;
use App\Mail\ContactInquiryMail;
use App\Mail\ContactConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Check if request is AJAX
        $isAjax = $request->ajax() || $request->wantsJson();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'service' => 'nullable|string',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please correct the errors below.',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

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
            $adminEmail = config('mail.from.address', 'info@ceylonayurvedahealth.co.uk');
            Mail::to($adminEmail)->send(new ContactInquiryMail($inquiry));

            // Send confirmation email to user
            Mail::to($inquiry->email)
                ->send(new ContactConfirmationMail($inquiry));

            // Return response
            $successMessage = 'Thank you for contacting us! We will get back to you soon.';
            
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'data' => [
                        'inquiry_id' => $inquiry->id
                    ]
                ]);
            }

            return redirect()->back()->with('success', $successMessage);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form submission error: ' . $e->getMessage(), [
                'data' => $validated,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return error response
            $errorMessage = 'Sorry, there was an error sending your message. Please try again later.';
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $errorMessage]);
        }
    }
}