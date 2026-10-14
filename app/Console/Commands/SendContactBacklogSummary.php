<?php

namespace App\Console\Commands;

use App\Mail\ContactBacklogSummary;
use App\Models\ContactSubmission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendContactBacklogSummary extends Command
{
    protected $signature = 'contact:send-backlog-summary
                            {--preview-to= : Send the summary to this address only, and mark nothing as sent}
                            {--exclude-email=* : Leave out submissions from this email address}
                            {--dry-run : List what would be sent without sending}';

    protected $description = 'Email every unsent contact submission to the owner as one summary';

    public function handle(): int
    {
        $exclude = array_map('strtolower', $this->option('exclude-email'));

        $submissions = ContactSubmission::unsent()
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->reject(fn ($submission) => in_array(strtolower($submission->email), $exclude, true))
            ->values();

        if ($submissions->isEmpty()) {
            $this->error('There are no unsent contact submissions to send.');

            return self::FAILURE;
        }

        $this->table(
            ['Date', 'Name', 'Email'],
            $submissions->map(fn ($s) => [
                $s->created_at->timezone('Africa/Johannesburg')->format('Y-m-d H:i'),
                $s->name,
                $s->email,
            ])->all()
        );

        if ($this->option('dry-run')) {
            $this->info("Dry run: {$submissions->count()} submission(s) would be sent. Nothing sent.");

            return self::SUCCESS;
        }

        if ($previewTo = $this->option('preview-to')) {
            Mail::to($previewTo)->send(new ContactBacklogSummary($submissions));
            $this->info("Preview of {$submissions->count()} submission(s) sent to {$previewTo}. Nothing marked as sent.");

            return self::SUCCESS;
        }

        $recipient = config('mail.contact.to');

        Mail::to($recipient)->send(new ContactBacklogSummary($submissions));

        ContactSubmission::whereKey($submissions->modelKeys())->update([
            'emailed_at' => now(),
            'emailed_via' => ContactSubmission::VIA_BACKLOG_SUMMARY,
        ]);

        $this->info("Summary of {$submissions->count()} submission(s) sent to {$recipient}.");

        return self::SUCCESS;
    }
}
