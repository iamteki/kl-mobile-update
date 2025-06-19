<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $serviceName;
    public $adminUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
        $this->serviceName = $inquiry->service_name;
        $this->adminUrl = url('/admin/contact-inquiries/' . $inquiry->id);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($this->inquiry->email, $this->inquiry->name)
                    ->subject('New Contact Inquiry - ' . $this->inquiry->name)
                    ->view('emails.contact-inquiry');
    }
}