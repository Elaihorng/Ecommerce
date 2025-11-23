<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use Endroid\QrCode\Builder\Builder;
use Carbon\Carbon;

class LicenseRenewalController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'current_license_number' => 'required|string|max:255',
        'photo'           => 'required|file|mimes:jpg,jpeg,png|max:3072',
        'delivery_option' => 'required|in:pickup,delivery',
    ]);

    $userId = Auth::id();
    if (!$userId) {
        return redirect()->route('login')->with('error', 'Please login to continue.');
    }

    // store files if present
    $photoPath = $request->hasFile('photo')
        ? $request->file('photo')->store('renewal_docs', 'public')
        : null;

    $medicalPath = $request->hasFile('medical_cert')
        ? $request->file('medical_cert')->store('renewal_docs', 'public')
        : null;

    // national id
    $nationalId = DB::table('national_id_cards')
        ->where('user_id', $userId)
        ->value('id');

    // 🔍 find existing license by current_license_number (or fallback by user)
    $license = DB::table('licenses')
    ->where('license_number', $validated['current_license_number'])
    ->orWhere(function ($q) use ($userId) {
        $q->where('user_id', $userId);
        })
        ->latest('id')
        ->first();

    $licenseId     = $license->id             ?? null;
    $applicationId = $license->application_id ?? null;

    // ✅ use permit from license, NOT a new one
    $permitNumber = $license->permit_number ?? null;
    // insert renewal record
    $renewalId = DB::table('license_renewals')->insertGetId([
        'application_id'       => $applicationId,
        'user_id'              => $userId,
        'license_id'           => $licenseId,
        'national_id'          => $nationalId,
        'permit_number'        => $permitNumber,
        'current_license_number' => $validated['current_license_number'],
        // 'photo'              => $photoPath,
        // 'medical_cert'       => $medicalPath,
        'delivery_option'      => $validated['delivery_option'],
        'status'               => 'submitted',
        'created_at'           => now(),
        'updated_at'           => now(),
    ]);

    return redirect()->route('renewal.checkout', ['renewal_id' => $renewalId])
        ->with('success', 'Renewal created. Please complete checkout to pay.');
}

    /**
     * Show checkout page for a renewal
     */
public function renewalCheckout(Request $request, $renewal_id)
{
    $renewal = DB::table('license_renewals')->where('id', $renewal_id)->first();
    if (!$renewal) {
        return redirect()->back()->with('error', 'Renewal not found.');
    }

    $user = DB::table('users')->where('id', $renewal->user_id)->first();

    // get license + application from IDs we stored
    $license = null;
    $application = null;

    if (!empty($renewal->license_id)) {
        $license = DB::table('licenses')->where('id', $renewal->license_id)->first();
    } else {
        // fallback by user if needed
        $license = DB::table('licenses')
            ->where('user_id', $renewal->user_id)
            ->latest('id')
            ->first();
    }

    if (!empty($renewal->application_id)) {
        $application = DB::table('applications')
            ->where('id', $renewal->application_id)
            ->first();
    }

    $licenseType = $license->license_type ?? 'Unknown';

    $amount   = 100;
    $currency = 'KHR';
    $permitNumber = $renewal->permit_number;

    return view('frontend.checkout_payment.checkout', [
        'permit_number'    => $permitNumber,
        'test_date'        => null,
        'test_time'        => null,
        'center_name'      => 'N/A - Renewal',
        'amount'           => $amount,
        'currency'         => $currency,

        'renewal_id'       => $renewal_id,
        'full_name'        => $user->full_name ?? $user->name ?? null,
        'user_email'       => $user->email ?? null,
        'user_phone'       => $user->phone ?? null,

        'license_type'     => $licenseType,
        'application_type' => 'renewal',

        // 👉 extra values you asked for
        'license_id'       => $license->id          ?? null,
        'application_id'   => $application->id      ?? null,
    ]);
}

    public function success($permit_number)
    {
        $renewal = DB::table('license_renewals')
            ->where('permit_number', $permit_number)
            ->latest('id')
            ->first();

        if (!$renewal) {
            return redirect()->route('/') // or wherever
                ->with('error', 'Renewal not found.');
        }

        $user = DB::table('users')->where('id', $renewal->user_id)->first();

        return view('frontend.renewal.success', [
            'renewal' => $renewal,
            'user'    => $user,
        ]);
    }


}
   