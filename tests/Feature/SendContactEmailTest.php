<?php

namespace Tests\Feature;

use App\Jobs\SendContactEmail;
use App\Mail\ContactEmail;
use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendContactEmailTest extends TestCase
{
    use RefreshDatabase;

    private function submission(array $overrides = []): ContactSubmission
    {
        return ContactSubmission::create(array_merge([
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'subject' => 'Website enquiry',
            'message' => 'Hello',
            'source' => ContactSubmission::SOURCE_FORM,
        ], $overrides));
    }

    public function test_the_job_sends_the_email_and_stamps_the_submission(): void
    {
        Mail::fake();
        config(['mail.contact.to' => 'owner@example.com']);
        $submission = $this->submission();

        (new SendContactEmail($submission))->handle();

        Mail::assertSent(ContactEmail::class, function (ContactEmail $mail) {
            return $mail->hasTo('owner@example.com')
                && $mail->hasReplyTo('jane@example.com', 'Jane Customer')
                && $mail->hasSubject('Website enquiry from Jane Customer');
        });

        $submission->refresh();
        $this->assertNotNull($submission->emailed_at);
        $this->assertSame(ContactSubmission::VIA_INDIVIDUAL, $submission->emailed_via);
    }

    public function test_the_job_is_idempotent(): void
    {
        Mail::fake();
        $submission = $this->submission(['emailed_at' => now()->subHour(), 'emailed_via' => 'individual']);

        (new SendContactEmail($submission))->handle();

        Mail::assertNothingSent();
    }

    public function test_the_mailable_takes_its_from_address_from_config(): void
    {
        config(['mail.from.address' => 'x@tightfit.co.za', 'mail.from.name' => 'TightFit Website']);

        Mail::to('owner@example.com')->send(new ContactEmail($this->submission()));

        $message = app('mailer')->getSymfonyTransport()->messages()->last()->getOriginalMessage();
        $this->assertSame('x@tightfit.co.za', $message->getFrom()[0]->getAddress());
    }
}
