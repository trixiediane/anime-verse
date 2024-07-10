<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\SendEmailNow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class EmailController extends Controller
{
    public function sendEmails()
    {
        try {
            $emails = [
                ['email' => 'trixiediane490@gmail.com', 'name' => 'Diane'],
                ['email' => 'jsoriano@diavox.net', 'name' => 'Jerome'],
                ['email' => 'rooneyphoenix490@gmail.com', 'name' => 'Rooney'],

                ['email' => 'rvillanueva@diavox.net', 'name' => 'Rolph'],
                ['email' => 'jalonzo@diavox.net', 'name' => 'Jhun'],
                ['email' => 'tbautista@diavox.net', 'name' => 'Diane'],
                // Add more email details
            ];

            $batchDelay = 60; // Delay between batches in seconds
            $batchSize = 3;   // Number of emails per batch

            $recipientChunks = array_chunk($emails, $batchSize);

            foreach ($recipientChunks as $index => $chunk) {
                // Dispatch job with delay for each batch
                SendEmailJob::dispatch($chunk)->delay(now()->addSeconds($index * $batchDelay));
            }

            Log::debug("Emails dispatched!");

            return response()->json(['message' => 'Emails dispatched!']);
        } catch (Exception $e) {
            Log::error("Error dispatching emails: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
