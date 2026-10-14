<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ContactBacklogSummary extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  Collection<int, ContactSubmission>  $submissions  oldest first
     */
    public function __construct(public Collection $submissions) {}

    /**
     * Get the message envelope. The From address comes from config('mail.from').
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undelivered website enquiries ('.$this->submissions->count().')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $format = fn ($date) => $date->timezone('Africa/Johannesburg')->format('j M Y');

        return new Content(
            html: 'emails.backlog-summary',
            with: [
                'first' => $format($this->submissions->first()->created_at),
                'last' => $format($this->submissions->last()->created_at),
            ],
        );
    }
}
