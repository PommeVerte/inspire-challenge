<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Tests for all validation Errors
     * PHPUNIT dataProvider, works by sampling it's dataset from provider()
     *
     * @param $name
     * @param $value
     *
     * @dataProvider provider
     */
    public function testValidationErrors(string $name, string $value): void
    {
        $response = $this->post(
            '/contact',
            [$name => $value]
        );
        $response->assertSessionHasErrors([$name], $name . " = " . $value . " should fail");
    }

    /**
     * All incorrect combinations that should fail
     *
     * @return array
     */
    public function provider(): array
    {
        return [
            ['full_name', ''],
            ['full_name', str_repeat('s', 130)],
            ['email', ''],
            ['email', 'incorrectemail'],
            ['email', str_repeat('s', 130) . '@gmail.com'], // too long
            ['email', '@em'],
            ['phone', 'not a number'],
            ['phone', '111111'],
            ['phone', str_repeat('s', 130)],
            ['message', ''],
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testContactRedirectsBackOnFailure(): void
    {
        $response = $this->from('/')->post(
            '/contact',
            []
        );
        $response->assertRedirect('/', 'Should redirect to /');
        $response->assertStatus(302, 'Should have a status of 302');
        $response->assertSessionHasErrors();
    }

    /**
     * Test successful post
     *
     * @return void
     */
    public function testSuccessfulPost(): void
    {
        $contact = Contact::factory()->definition();
        $response = $this->post(
            '/contact',
            $contact
        );
        $response->assertStatus(200, 'Should succeed and have a status of 200');
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(
            'contacts',
            $contact
        );
    }

    /**
     * Test non-ajax graceful degradation successful post view
     *
     * @return void
     */
    public function testCorrectNonAjaxViewOnSuccess(): void
    {
        $contact = Contact::factory()->definition();
        $response = $this->post(
            '/contact',
            $contact
        );
        $response->assertViewIs('success');
    }

    /**
     * Test successful post response on ajax call
     *
     * @return void
     */
    public function testCorrectAjaxResponseOnSuccess(): void
    {
        $contact = Contact::factory()->definition();
        $response = $this->postJson(
            '/contact',
            $contact,
            [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ],
        );
        $response->assertStatus(200, 'Should succeed and have a status of 200');
        $response->assertSessionHasNoErrors();
        $response->assertExactJson(['success' => true]);
    }

    /**
     * Test failed post response on ajax call
     *
     * @return void
     */
    public function testCorrectAjaxResponseOnFailure(): void
    {
        $response = $this->postJson(
            '/contact',
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest'],
        );
        $response->assertStatus(422, 'Should succeed and have a status of 422');
        $response->assertJsonCount(2);
        $response->assertJsonValidationErrors('full_name');
    }

    /**
     * Tests for all incorrect http verbs
     * PHPUNIT dataProvider, works by sampling it's dataset from verbProvider()
     *
     * @param $verb
     *
     * @dataProvider verbProvider
     */
    public function testRejectedVerbs($verb): void
    {
        $response = $this->call(
            $verb,
            '/contact',
            []
        );
        $response->assertStatus(405);
    }

    /**
     * All incorrect verbs that should fail
     *
     * @return array
     */
    public function verbProvider(): array
    {
        return [
            ['GET'],
            ['PUT'],
            ['PATCH'],
            ['DELETE'],
            ['HEAD'],
            ['CONNECT'],
            ['TRACE'],
        ];
    }
}
