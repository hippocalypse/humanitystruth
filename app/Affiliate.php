<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'logo', 'website', 'account_id'
    ];

    protected $table = 'affiliates';
}
