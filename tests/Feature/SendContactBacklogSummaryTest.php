<?php

namespace Tests\Feature;

use App\Mail\ContactBacklogSummary;
use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendContactBacklogSummaryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['mail.contact.to' => 'owner@example.com']);
    }

    private function submission(string $email, string $createdAt, array $overrides = []): ContactSubmission
    {
        $submission = new ContactSubmission(array_merge([
            'name' => 'Customer '.$email,
            'email' => $email,
            'message' => "Line one <b>bold</b>\nLine two",
            'source' => ContactSubmission::SOURCE_QUEUE_BACKLOG,
        ], $overrides));
        $submission->created_at = $createdAt;
        $submission->save();

        return $submission;
    }

    public function test_preview_sends_one_mail_to_the_preview_address_and_stamps_nothing(): void
    {
        Mail::fake();
        $this->submission('a@example.com', '2026-05-01 10:00:00');
        $this->submission('b@example.com', '2026-06-01 10:00:00');

        $this->artisan('contact:send-backlog-summary', ['--preview-to' => 'johan@example.com'])
            ->assertSuccessful();

        Mail::assertSentCount(1);
        Mail::assertSent(ContactBacklogSummary::class, fn ($mail) => $mail->hasTo('johan@example.com')
            && ! $mail->hasTo('owner@example.com')
            && $mail->submissions->count() === 2);

        $this->assertSame(2, ContactSubmission::unsent()->count());
    }

    public function test_real_send_mails_the_owner_once_and_stamps_the_included_rows(): void
    {
        Mail::fake();
        $test = $this->submission('johan@example.com', '2026-04-22 09:00:00');
        $later = $this->submission('b@example.com', '2026-06-01 10:00:00');
        $earlier = $this->submission('a@example.com', '2026-05-01 10:00:00');
        $alreadySent = $this->submission('c@example.com', '2026-05-15 10:00:00', [
            'emailed_at' => '2026-05-15 10:01:00',
            'emailed_via' => ContactSubmission::VIA_INDIVIDUAL,
        ]);

        $this->artisan('contact:send-backlog-summary', ['--exclude-email' => ['Johan@example.com']])
            ->assertSuccessful();

        Mail::assertSentCount(1);
        Mail::assertSent(ContactBacklogSummary::class, function (ContactBacklogSummary $mail) use ($earlier, $later) {
            $html = $mail->render();

            $this->assertStringContainsString('mailto:a@example.com', $html);
            $this->assertStringContainsString('Line one &lt;b&gt;bold&lt;/b&gt;<br />', $html);
            $this->assertStringNotContainsString('johan@example.com', $html);
            $this->assertEmpty($mail->replyTo);

            return $mail->hasTo('owner@example.com')
                && $mail->submissions->pluck('id')->all() === [$earlier->id, $later->id];
        });

        $this->assertSame(ContactSubmission::VIA_BACKLOG_SUMMARY, $earlier->fresh()->emailed_via);
        $this->assertSame(ContactSubmission::VIA_BACKLOG_SUMMARY, $later->fresh()->emailed_via);
        $this->assertNotNull($later->fresh()->emailed_at);
        $this->assertNull($test->fresh()->emailed_at);
        $this->assertSame(ContactSubmission::VIA_INDIVIDUAL, $alreadySent->fresh()->emailed_via);
    }

    public function test_dry_run_sends_nothing(): void
    {
        Mail::fake();
        $this->submission('a@example.com', '2026-05-01 10:00:00');

        $this->artisan('contact:send-backlog-summary', ['--dry-run' => true])
            ->expectsOutputToContain('a@example.com')
            ->assertSuccessful();

        Mail::assertNothingSent();
        $this->assertSame(1, ContactSubmission::unsent()->count());
    }

    public function test_it_fails_when_there_is_nothing_to_send(): void
    {
        Mail::fake();

        $this->artisan('contact:send-backlog-summary')->assertFailed();

        Mail::assertNothingSent();
    }
}
