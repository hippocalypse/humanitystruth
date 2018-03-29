<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'verification_code', 'expiration'
    ];
    
}
