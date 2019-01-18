<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Abraham\TwitterOAuth\TwitterOAuth;

class SendTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $conn;
    private $tweet;
    private $media;
    
    /**
     * Create a new job instance.
     *
     * @param $media The local file path to the image to upload.
     * @param $tweet The text to tweet.
     * @return void
     */
    public function __construct($tweet, $media = null)
    {
        $this->conn = new TwitterOAuth(
            env("TWITTER_API_KEY"),
            env("TWITTER_API_SECRET_KEY"),
            env("TWITTER_ACCESS_TOKEN"),
            env("TWITTER_ACCESS_TOKEN_SECRET")
        );
        //ensure that tweet must be less than 280 characters...
        if(strlen($tweet) > 280) {
            $tweet = substr($tweet, 0, 280);
        }
            
        $this->tweet = $tweet;
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->media == null) {
            $this->conn->post("statuses/update", ["status" => $this->tweet]);
        
        } else {
            $upload = $this->conn->upload('media/upload', ['media' => $this->media]);
            $parameters = [
                'status' => $this->tweet,
                'media_ids' => $upload->media_id_string
            ];
            
            $this->conn->post('statuses/update', $parameters);
        }
    }
}
