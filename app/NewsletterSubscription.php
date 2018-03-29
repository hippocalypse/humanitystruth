<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class NewsletterSubscription extends Model
{
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'authenticate_token', 'unsubscribe_token'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'authenticate_token', 'unsubscribe_token'
    ];
    
    /**
     * A NewsletterSubscription has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'email');
    }
}
