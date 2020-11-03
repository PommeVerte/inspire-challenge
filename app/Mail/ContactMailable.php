<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContactMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     *
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->contact->email, $this->contact->full_name)
                    ->subject('New ContactForm submission by ' . Str::limit($this->contact->full_name, 10))
                    ->markdown('emails.contact')
                    ->with(['contact' => $this->contact]);
    }
}
