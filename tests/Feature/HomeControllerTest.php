<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * Testing / status and view
     *
     * @return void
     */
    public function testLandingStatusAndView()
    {
        $response = $this->get('/');

        $response->assertStatus(200, "'/' should return a status 200");
        $response->assertViewIs('welcome', "'/' should return the 'welcome' view");
    }

    /**
     * Testing that the view is reloaded with proper data on submit fail
     *
     * @return void
     */
    public function testWelcomeViewHasExpectedDataOnSubmitFail()
    {
        $response = $this->followingRedirects()->from('/')->post(
            '/contact',
            []
        );

        $response->assertStatus(200, "'/' should return a status 200");
        $response->assertViewIs('welcome', "'/' should return the 'welcome' view");

        //cheap check, this should be covered more solidly by selenium tests (accounting for lang)
        $response->assertSeeInOrder(
            [
                'The full name field is required.',
                'The email field is required.',
                'The message field is required.',
            ]
        );
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
            '/',
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
            ['POST'],
            ['PUT'],
            ['PATCH'],
            ['DELETE'],
            ['CONNECT'],
            ['TRACE'],
        ];
    }
}
