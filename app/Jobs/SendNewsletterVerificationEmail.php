<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\EmailNewsletterVerification;

class SendNewsletterVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscription;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailNewsletterVerification($this->subscription);
        Mail::to($this->subscription->email)->send($email);
    }
}
