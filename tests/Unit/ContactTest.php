<?php

namespace Tests\Unit;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreate()
    {
        // Create a single App\Models\Contact instance...
        $contact = Contact::factory()->create();

        $this->assertDatabaseHas(
            'contacts',
            [
                'full_name' => $contact->full_name,
                'email'     => $contact->email,
                'phone'     => $contact->phone,
                'message'   => $contact->message,
            ]
        );
    }
}
