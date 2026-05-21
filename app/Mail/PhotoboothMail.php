<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class PhotoboothMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $imagePath;
    public string $downloadUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $imagePath)
    {
        $this->imagePath = $imagePath;
        $this->downloadUrl = route('photo.download', ['filename' => basename($imagePath)]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Foto Strip MoSafe Photobooth Anda',
            replyTo: [
                new Address('mosafe@dyanaf.com', 'MoSafe Photobooth'),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.photobooth',
            text: 'emails.photobooth_plain',
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
