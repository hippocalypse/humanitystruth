<?php

namespace tests\Unit;

use tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends TestCase
{
    //use DatabaseMigrations;
    
    /** @test */
    public function a_email_account_can_not_use_2fa()
    {
        $user = create('App\User');

        //
    }

    /** @test */
    function a_phone_account_must_login_with_2fa()
    {
        //
    }
    
    /** @test */
    function too_many_2fa_attempts_will_throttle_connection()
    {
        //
    }
}
