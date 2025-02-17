<?php

namespace App\Jobs;

use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $incoming;

    /**
     * Create a new job instance.
     */
    public function __construct($incoming)
    {
        $this->incoming = $incoming;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('tightfit@hermanus.co.za')->send(new ContactEmail(
            [
                'subject' => $this->incoming['subject'],
                'name' => $this->incoming['name'],
                'email' => $this->incoming['email'],
                'message' => $this->incoming['message'],
            ]
        ));
    }
}
