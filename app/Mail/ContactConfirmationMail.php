<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $serviceName;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
        $this->serviceName = $inquiry->service_name;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Thank you for contacting KL Mobile Events')
                    ->view('emails.contact-confirmation');
    }
}