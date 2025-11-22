<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $booking;
    public $application;

    public function __construct($user, $booking, $application)
    {
        $this->user = $user;
        $this->booking = $booking;
        $this->application = $application;
    }

    public function build()
    {
        return $this->subject('Your Driving Test Booking is Confirmed and paid')
                    ->markdown('emails.booking.success');
    }
}
