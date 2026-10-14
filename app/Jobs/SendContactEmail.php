<?php

namespace App\Jobs;

use App\Mail\ContactEmail;
use App\Models\ContactSubmission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $backoff = [60, 300];

    /**
     * Create a new job instance.
     */
    public function __construct(public ContactSubmission $submission) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Already sent (e.g. a retry after the mail went out): do nothing
        if ($this->submission->emailed_at !== null) {
            return;
        }

        Mail::to(config('mail.contact.to'))->send(new ContactEmail($this->submission));

        $this->submission->update([
            'emailed_at' => now(),
            'emailed_via' => ContactSubmission::VIA_INDIVIDUAL,
        ]);
    }
}
