<?php

namespace tests\Unit;

use tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    //use DatabaseMigrations;
    
    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');

        $reply = create('Modules\Developers\Entities\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    function a_user_can_determine_their_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals(asset('data/imgs/avatars/default.png'), $user->avatar_path);

        $user->avatar_path = 'data/imgs/avatars/hippo.jpg';

        $this->assertEquals(asset('data/imgs/avatars/hippo.jpg'), $user->avatar_path);
    }
}
