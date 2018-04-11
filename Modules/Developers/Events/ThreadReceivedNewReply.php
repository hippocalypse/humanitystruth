<?php

namespace Modules\Developers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadReceivedNewReply
{
    use Dispatchable, SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
    
    //fire thread was updated notification to each subscriber?
}
