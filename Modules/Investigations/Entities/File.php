<?php

namespace Modules\Investigations\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function tags()
    {
       return  $this->belongsToMany(Tag::class);
    }
    
    public function investigations()
    {
       return  $this->belongsToMany(Investigation::class);
    }
}
