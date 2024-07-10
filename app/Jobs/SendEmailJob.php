<?php

namespace App\Jobs;

use App\Mail\SendEmailNow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        $batchSize = 2;
        $recipientChunks = array_chunk($this->details, $batchSize);

        foreach ($recipientChunks as $chunk) {
            foreach ($chunk as $recipient) {
                Mail::to($recipient['email'])->send(new SendEmailNow($recipient));
            }
        }
    }
}
