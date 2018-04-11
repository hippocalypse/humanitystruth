<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Carrier;
use Modules\Developers\Entities\Reply;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'phone', 'phone_carrier_id', 'alias', 'password', 'email_token', 'role', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'email';
    }


    /**
     * Fetch the email address we need to send text messages (2-factor authentication) to.
     * Example: 0123456789@txt.att.net
     * 
     * @return string <phone-number>@<carrier suffix>
     */
    public final function smsAddress() {
        return Carrier::find($this->phone_carrier_id)->format($this->phone);
    }
    
    /**
     * Fetch all threads that were created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * Fetch the last published reply for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * Get all activity for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(\Modules\Developers\Entities\Activity::class);
    }

    /**
     * Mark the user's account as email confirmed.
     */
    public function confirmEmail()
    {
        if($this->role == "phone_verified") $this->role = "both_verified";
        else $this->role = "email_verified";
        return $this->save();
    }
    
    /**
     * Mark the user's account as email confirmed.
     */
    public function confirmPhone()
    {
        if($this->role == "email_verified") $this->role = "both_verified";
        else $this->role = "phone_verified";
        return $this->save();
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == "admin" || $this->role == "super_admin";
    }
    
    /**
     * Determine if the user is an moderator.
     *
     * @return bool
     */
    public function isModerator()
    {
        return $this->role == "moderator";
    }
    
    /**
     * Determine if the user has a verified account.
     *
     * @return bool
     */
    public function hasVerified()
    {
        return $this->role != "closed" && $this->role != "inactive";
    }

    /**
     * Record that the user has read the given thread.
     *
     * @param Thread $thread
     */
    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }
    
    /**
     * Get the path to the user's profile.
     *
     * @param  string $avatar
     * @return string
     */
    public function getProfileLink()
    {
        return "<a href='/profiles/" . $this->alias . "'>".$this->alias."</a>";
    }

    /**
     * Get the path to the user's avatar.
     *
     * @param  string $avatar
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ?: 'data/imgs/avatars/default.png');
    }

    /**
     * Get the cache key for when a user reads a thread.
     *
     * @param  Thread $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }
}
