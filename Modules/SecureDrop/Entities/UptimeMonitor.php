<?php

namespace Modules\SecureDrop\Entities;

use Illuminate\Database\Eloquent\Model;

class UptimeMonitor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'uptime_status'
    ];
}
