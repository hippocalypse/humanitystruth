<?php

namespace Modules\Developers\Http\Controllers;

use Modules\Developers\Entities\Activity;
use Modules\Developers\Entities\User;

class ProfilesController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  User $user
     * @return \Response
     */
    public function show(User $user)
    {
        return view('developers::profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }
}
