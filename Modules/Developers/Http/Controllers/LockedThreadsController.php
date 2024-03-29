<?php

namespace Modules\Developers\Http\Controllers;

use Modules\Developers\Entities\Thread;

class LockedThreadsController extends Controller
{
    /**
     * Lock the given thread.
     *
     * @param \App\Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->update(['locked' => true]);
    }

    /**
     * Unlock the given thread.
     *
     * @param \App\Thread $thread
     */
    public function destroy(Thread $thread)
    {
        $thread->update(['locked' => false]);
    }
}
