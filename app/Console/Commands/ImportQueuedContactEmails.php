<?php

namespace App\Console\Commands;

use App\Models\ContactSubmission;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ImportQueuedContactEmails extends Command
{
    protected $signature = 'contact:import-queued
                            {--queue=tightfit : The queue the stuck jobs sit on}
                            {--dry-run : List what would be imported without writing anything}';

    protected $description = 'Move stuck SendContactEmail jobs (old array payload) into contact_submissions';

    public function handle(): int
    {
        $table = config('queue.connections.database.table', 'jobs');
        $dryRun = (bool) $this->option('dry-run');

        $jobs = DB::table($table)
            ->where('queue', $this->option('queue'))
            ->orderBy('id')
            ->get()
            ->filter(fn ($job) => (json_decode($job->payload, true)['displayName'] ?? null) === 'App\Jobs\SendContactEmail');

        $rows = [];
        $imported = 0;
        $skipped = 0;

        foreach ($jobs as $job) {
            $incoming = $this->decodeIncoming($job->payload);

            if ($incoming === null) {
                $this->warn("Job {$job->id}: could not decode the payload, left in place.");

                continue;
            }

            $createdAt = Carbon::createFromTimestamp($job->created_at, config('app.timezone'));
            $message = preg_replace('/<br\s*\/?>/i', '', (string) ($incoming['message'] ?? ''));

            $rows[] = [$createdAt->format('Y-m-d H:i'), $incoming['name'] ?? '', $incoming['email'] ?? ''];

            if ($dryRun) {
                continue;
            }

            DB::transaction(function () use ($table, $job, $incoming, $createdAt, $message, &$imported, &$skipped) {
                $exists = ContactSubmission::where('email', $incoming['email'] ?? '')
                    ->where('created_at', $createdAt)
                    ->where('message', $message)
                    ->exists();

                if ($exists) {
                    $skipped++;
                } else {
                    $submission = new ContactSubmission([
                        'name' => $incoming['name'] ?? '',
                        'email' => $incoming['email'] ?? '',
                        'subject' => $incoming['subject'] ?? null,
                        'message' => $message,
                        'source' => ContactSubmission::SOURCE_QUEUE_BACKLOG,
                    ]);
                    $submission->created_at = $createdAt;
                    $submission->save();
                    $imported++;
                }

                DB::table($table)->where('id', $job->id)->delete();
            });
        }

        $this->table(['Date', 'Name', 'Email'], $rows);

        if ($dryRun) {
            $this->info('Dry run: '.count($rows).' job(s) found, nothing written.');
        } else {
            $this->info("Imported {$imported}, skipped {$skipped} already-imported, jobs deleted: ".($imported + $skipped).'.');
        }

        return self::SUCCESS;
    }

    /**
     * Read the `incoming` array off an old-shape job payload without instantiating the job class.
     */
    private function decodeIncoming(string $payload): ?array
    {
        $command = json_decode($payload, true)['data']['command'] ?? null;

        if (! is_string($command)) {
            return null;
        }

        $object = @unserialize($command, ['allowed_classes' => false]);

        if (! is_object($object)) {
            return null;
        }

        $incoming = ((array) $object)['incoming'] ?? null;

        return is_array($incoming) && isset($incoming['email']) ? $incoming : null;
    }
}
