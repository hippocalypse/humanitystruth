<?php

namespace tests\Feature;

use App\Mail\EmailVerification;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post(route('register'), [
            'alias' => 'johndoe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'phone_carrier_id' => '4',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        Mail::assertQueued(EmailVerification::class);
    }

    /** @test */
    function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post(route('register'), [
            'alias' => 'johndoe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'phone_carrier_id' => '4',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        $user = User::whereEmail('john@example.com')->first();

        $this->assertTrue($user->role == "inactive");
        $this->assertNotNull($user->email_token);

        $this->get(route('register.confirm', ['token' => $user->email_token]))
            ->assertRedirect(route('threads'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->role == "email_confirmed");
            $this->assertNull($user->email_token);
        });
    }

    /** @test */
    function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHasErrors();
    }
}
