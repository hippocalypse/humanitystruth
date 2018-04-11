<?php

namespace tests\Unit;

use Modules\Developers\Entities\Reply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use tests\TestCase;

class ReplyTest extends TestCase
{
    //use DatabaseMigrations;

    /** @test */
    function a_reply_has_an_owner()
    {
        $reply = create('Modules\Developers\Entities\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    function a_reply_knows_if_it_was_just_published()
    {
        $reply = create('Modules\Developers\Entities\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    function a_reply_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new Reply([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    /** @test */
    function a_reply_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new Reply([
            'body' => 'Hello @Jane-Doe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );

    }

    /** @test */
    function a_reply_knows_if_it_is_the_best_reply()
    {
        $reply = create('Modules\Developers\Entities\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    function a_reply_body_is_sanitized_automatically()
    {
        $reply = make('Modules\Developers\Entities\Reply', ['body' => '<script>alert("bad")</script><p>This is okay.</p>']);

        $this->assertEquals("<p>This is okay.</p>", $reply->body);
    }
}
