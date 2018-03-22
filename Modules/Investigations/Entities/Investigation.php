<?php

namespace Modules\Investigations\Entities;

use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
    public function tags()
    {
       return  $this->belongsToMany(Tag::class);
    }
    
    public function files()
    {
       return  $this->belongsToMany(File::class);
    }
}
