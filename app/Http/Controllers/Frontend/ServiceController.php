<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ServiceController extends Controller
{
    public function index(){

        return view('frontend.service.index');
    }


    public function register(){
        return view('frontend.service.register');
    }

    public function renew(){
        return view('frontend.service.renew');
    }



    public function booktest(){
        return view('frontend.service.bookTest');
    }

    public function checkStatusView()
{
    return view('frontend.service.checkstatus');
}
public function checkStatus(Request $request)
{
    
    $request->validate([
        'permit_number' => 'nullable|string',
        'phone'         => 'nullable|string',
    ]);

    if (!$request->permit_number && !$request->phone) {
        return back()->with('error', 'Please enter your Permit Number or Phone Number.');
    }

    $query = DB::table('applications');

    if ($request->permit_number) {
        $query->where('permit_number', $request->permit_number);
    }

    if ($request->phone) {
        $query->where('phone', $request->phone);
    }

    $application = $query->first();

    if (!$application) {
        return back()->with('error', 'No record found with that permit number or phone number.');
    }

    // Latest booking for this application
    $booking = DB::table('bookings')
        ->where('application_id', $application->id)
        ->orderByDesc('id')
        ->first();

    // Latest test result for this booking (if any)
    $testResult = null;
    if ($booking) {
        $testResult = DB::table('test_results')
            ->where('booking_id', $booking->id)
            ->orderByDesc('id')
            ->first();
    }

    return view('frontend.service.status_result', [
        'application' => $application,
        'booking'     => $booking,      // has b_status
        'testResult'  => $testResult,   // theory/practical status
    ]);
}


    public function downloadDucument(){
        return view('frontend.service.download');
    }
}