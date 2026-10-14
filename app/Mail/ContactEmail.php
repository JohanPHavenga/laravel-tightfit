<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ContactSubmission $submission) {}

    /**
     * Get the message envelope. The From address comes from config('mail.from').
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Website enquiry from '.$this->submission->name,
            replyTo: [
                new Address($this->submission->email, $this->submission->name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.contact',
            text: 'emails.contact-text',
            with: [
                'name' => $this->submission->name,
                'email' => $this->submission->email,
                'mail_message' => $this->submission->message,
                'submitted_at' => $this->submission->created_at
                    ->timezone('Africa/Johannesburg')
                    ->format('j M Y, H:i'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
