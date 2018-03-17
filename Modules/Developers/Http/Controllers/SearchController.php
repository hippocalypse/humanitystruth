<?php

namespace Modules\Developers\Http\Controllers;

use Modules\Developers\Entities\Thread;
use Modules\Developers\Entities\Trending;

class SearchController extends Controller
{
    /**
     * Show the search results.
     *
     * @param  \App\Trending $trending
     * @return mixed
     */
    public function show(Trending $trending)
    {
        if (request()->expectsJson()) {
            return Thread::search(request('q'))->paginate(25);
        }

        return view('threads.search', [
            'trending' => $trending->get()
        ]);
    }
}
