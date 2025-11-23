<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $fullName;
    public string $verifyUrl;

    public function __construct(string $fullName, string $verifyUrl)
    {
        $this->fullName = $fullName;
        $this->verifyUrl = $verifyUrl;
    }

    public function build()
    {
        return $this->subject('Verify your email address')
                    ->view('emails.verify-email');
    }
}
