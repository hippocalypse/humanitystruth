<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    public $timestamps = false;
    
    public $prefix = "number@";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'suffix'
    ];
 
    //wrapper for sms phone carriers, we aren't paying for a 2FA service...
    public function format($number) {
        //todo: ensure $number is a 10 digit numerical value
        return $number . (strpos($this->suffix, '@') !== false ?: "@") . $this->suffix;
        
    }
}
