<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $name, public string $password)
    {

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo usuário cadastrado',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.new',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
