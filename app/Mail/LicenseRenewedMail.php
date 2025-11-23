<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Licenses;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LicenseRenewedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Licenses $license;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Licenses $license)
    {
        $this->user    = $user;
        $this->license = $license;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Your Driver License Has Been Renewed')
            ->markdown('emails.license.renewed');
    }
}
