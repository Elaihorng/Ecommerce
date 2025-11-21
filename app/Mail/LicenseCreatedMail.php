<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LicenseCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $license;

    public function __construct($user, $license)
    {
        $this->user = $user;
        $this->license = $license;
    }

    public function build()
    {
        return $this->subject('✅ Your License Has Been Created')
                    ->view('emails.license_created');
    }
}
