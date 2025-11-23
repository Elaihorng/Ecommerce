<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(){
        return view('frontend.checkout_payment.checkout');
    }

    public function payment(){
        return view('frontend.checkout_payment.payment');
    }
    public function bookingSuccess($permit_number)
    {
        // 1) Find the latest booking for this permit
        $booking = DB::table('bookings')
            ->where('permit_number', $permit_number)
            ->latest('id')
            ->first();

        if (!$booking) {
            return redirect()->route('home')
                ->with('error', 'Booking not found.');
        }

        // 2) Get user
        $user = DB::table('users')
            ->where('id', $booking->user_id)
            ->first();

        // 3) Get application
        $application = DB::table('applications')
            ->where('id', $booking->application_id)
            ->first();

        // 4) Pass everything to the success view
        return view('frontend.checkout_payment.success', [
            'user'          => $user,
            'booking'       => $booking,
            'application'   => $application,
            'permit_number' => $permit_number,
        ]);
    }
}
