<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\SmsCode;

class EmailSMSCode extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    private $sms;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $date = new DateTime();
        $date->modify("+5 minutes");
        
        $this->user = $user;
        $this->sms = SmsCode::create([
            'phone' => $this->user->phone,          
            'verification_code' => substr(bin2hex(random_bytes(32)), mt_rand(0, 22), 10),
            'expiration' => $date
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.two-factor-code')->with(['token' => $this->sms->verification_code]);
    }
}
