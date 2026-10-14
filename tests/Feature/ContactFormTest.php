<?php

namespace Tests\Feature;

use App\Jobs\SendContactEmail;
use App\Mail\ContactEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['honeypot.enabled' => false]);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'subject' => 'Website enquiry',
            'message' => "My garage door is stuck.\nPlease call me.",
        ], $overrides);
    }

    public function test_a_contact_submission_is_persisted(): void
    {
        // A real database queue, so the queue name the job lands on is what the worker would see
        config(['queue.default' => 'database']);

        $response = $this->post('/contact', $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('contact_submissions', 1);
        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'source' => 'form',
            'message' => "My garage door is stuck.\nPlease call me.",
            'emailed_at' => null,
        ]);

        $job = DB::table('jobs')->sole();
        $this->assertSame('default', $job->queue);
        $this->assertSame(SendContactEmail::class, json_decode($job->payload, true)['displayName']);
    }

    public function test_validation_rejects_missing_fields_and_an_over_long_message(): void
    {
        Queue::fake();

        $this->post('/contact', [])
            ->assertRedirect(route('contact.show'))
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->post('/contact', $this->validPayload(['message' => str_repeat('a', 10001)]))
            ->assertRedirect(route('contact.show'))
            ->assertSessionHasErrors(['message']);

        $this->assertDatabaseCount('contact_submissions', 0);
        Queue::assertNothingPushed();
    }

    public function test_the_message_is_html_escaped_in_the_email(): void
    {
        Mail::fake();

        $this->post('/contact', $this->validPayload([
            'message' => "Click <a href=\"http://evil\">x</a>\nthanks",
        ]))->assertSessionHasNoErrors();

        Mail::assertSent(ContactEmail::class, function (ContactEmail $mail) {
            $html = $mail->render();

            $this->assertStringNotContainsString('<a href="http://evil">', $html);
            $this->assertStringContainsString('&lt;a href=&quot;http://evil&quot;&gt;x&lt;/a&gt;<br />', $html);

            return true;
        });
    }
}
