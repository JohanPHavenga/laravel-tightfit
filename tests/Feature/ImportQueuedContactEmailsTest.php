<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ImportQueuedContactEmailsTest extends TestCase
{
    use RefreshDatabase;

    private const JOB_TIME = 1776852000; // 2026-04-22

    /**
     * Inserts a job row carrying a payload serialised by the old (array-based) SendContactEmail.
     */
    private function insertOldJob(string $queue = 'tightfit'): int
    {
        return DB::table('jobs')->insertGetId([
            'queue' => $queue,
            'payload' => trim(file_get_contents(base_path('tests/Fixtures/old-send-contact-email-payload.json'))),
            'attempts' => 0,
            'reserved_at' => null,
            'available_at' => self::JOB_TIME,
            'created_at' => self::JOB_TIME,
        ]);
    }

    public function test_it_imports_an_old_shape_payload_and_deletes_the_job(): void
    {
        $jobId = $this->insertOldJob();
        $otherQueueJob = $this->insertOldJob('default');

        $this->artisan('contact:import-queued')
            ->expectsOutputToContain('pieter@example.com')
            ->assertSuccessful();

        $this->assertDatabaseCount('contact_submissions', 1);
        $submission = ContactSubmission::first();
        $this->assertSame('Pieter Customer', $submission->name);
        $this->assertSame('pieter@example.com', $submission->email);
        $this->assertSame('Website enquiry', $submission->subject);
        $this->assertSame("Please quote for a double door.\nThanks", $submission->message);
        $this->assertSame(ContactSubmission::SOURCE_QUEUE_BACKLOG, $submission->source);
        $this->assertSame(self::JOB_TIME, $submission->created_at->timestamp);
        $this->assertNull($submission->emailed_at);

        $this->assertDatabaseMissing('jobs', ['id' => $jobId]);
        $this->assertDatabaseHas('jobs', ['id' => $otherQueueJob]);
    }

    public function test_import_is_idempotent(): void
    {
        $this->insertOldJob();
        $this->artisan('contact:import-queued')->assertSuccessful();

        // The same job again, e.g. restored from a backup
        $this->insertOldJob();
        $this->artisan('contact:import-queued')->assertSuccessful();

        $this->assertDatabaseCount('contact_submissions', 1);
        $this->assertDatabaseCount('jobs', 0);
    }

    public function test_dry_run_writes_nothing(): void
    {
        $this->insertOldJob();

        $this->artisan('contact:import-queued', ['--dry-run' => true])
            ->expectsOutputToContain('pieter@example.com')
            ->assertSuccessful();

        $this->assertDatabaseCount('contact_submissions', 0);
        $this->assertDatabaseCount('jobs', 1);
    }
}
