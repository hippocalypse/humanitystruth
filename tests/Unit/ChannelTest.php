<?php

namespace tests\Unit;

use tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    //use DatabaseMigrations;
    
    /** @test */
    public function a_channel_consists_of_threads()
    {
        $channel = create('Modules\Developers\Entities\Channel');
        $thread = create('Modules\Developers\Entities\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
