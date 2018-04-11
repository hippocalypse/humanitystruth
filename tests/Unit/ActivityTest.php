<?php

namespace tests\Unit;

use Modules\Developers\Entities\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use tests\TestCase;

class ActivityTest extends TestCase
{
    //use DatabaseMigrations;

    /** @test *
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('Modules\Developers\Entities\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'Modules\Developers\Entities\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test *
    function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('Modules\Developers\Entities\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /** @test *
    function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create('Modules\Developers\Entities\Thread', ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }*/
}
