<?php

namespace Tests\Feature;

use App\Jobs\ContactFormJob;
use App\Mail\ContactMailable;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormJobTest extends TestCase
{
    /**
     * Checking to see if the Job handler sends the email
     *
     * @return void
     */
    public function testHandleAndSendMail()
    {
        Mail::fake();

        $contact = Contact::factory()->make();

        $job = new ContactFormJob($contact);
        $this->assertTrue($job->handle());


        Mail::assertSent(
            ContactMailable::class,
            function ($mail) use ($contact) {
                return $mail->hasTo(config('mail.contact.to')) &&
                    true;//$mail->hasReplyTo($contact->email, $contact->full_name);
            }
        );
    }
}
