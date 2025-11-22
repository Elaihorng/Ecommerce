<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        // Latest application for this user
        $application = DB::table('applications')
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->first();

        $booking     = null;
        $testResult  = null;
        $licenseStatus = 'no_application';

        if ($application) {
            // Latest booking for that application
            $booking = DB::table('bookings')
                ->where('application_id', $application->id)
                ->orderByDesc('id')
                ->first();

            if ($booking) {
                // Latest test result for that booking
                $testResult = DB::table('test_results')
                    ->where('booking_id', $booking->id)
                    ->orderByDesc('id')
                    ->first();
            }

            // Decide license status
            $appStatus = strtolower($application->app_status ?? 'pending');
            $bStatus   = strtolower($booking->b_status ?? '');

            $theory    = strtolower($testResult->theory_result ?? '');
            $practical = strtolower($testResult->practical_result ?? '');

            if ($appStatus === 'approved'
                && in_array($bStatus, ['confirmed', 'completed'])
                && $theory === 'pass'
                && $practical === 'pass') {

                $licenseStatus = 'active';
            } elseif ($appStatus === 'rejected') {
                $licenseStatus = 'rejected';
            } elseif ($appStatus === 'approved' && !$testResult) {
                $licenseStatus = 'waiting_test';
            } else {
                $licenseStatus = 'in_progress';
            }
        }

        return view('frontend.license.index', [
            'user'          => $user,
            'application'   => $application,
            'booking'       => $booking,
            'testResult'    => $testResult,
            'licenseStatus' => $licenseStatus,
        ]);
    }
}
