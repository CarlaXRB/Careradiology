<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable\Address;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(){}
    public function envelope()
    {
        return new Envelope(
            subject: 'Bienvenido a CareRadiology',
            from: new Address(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'))
        );
    }
    public function content()
    {
        return new Content(
            view: 'emails.welcome-careradiology',
        );
    }
    public function attachments()
    {
        return [];
    }
}
