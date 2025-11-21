<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverPermitIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $fullName;
    public string $permitNumber;

    /**
     * Create a new message instance.
     */
    public function __construct(string $fullName, string $permitNumber)
    {
        $this->fullName = $fullName;
        $this->permitNumber = $permitNumber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Driver Permit Registration')
                    ->view('emails.driver-permit')
                    ->with([
                        'fullName' => $this->fullName,
                        'permitNumber' => $this->permitNumber,
                    ]);
    }
}
