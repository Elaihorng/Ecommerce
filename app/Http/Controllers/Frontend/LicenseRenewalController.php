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
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:3072',
            'delivery_option' => 'required|in:pickup,delivery',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // store files if present
        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('renewal_docs', 'public') : null;
        $medicalPath = $request->hasFile('medical_cert') ? $request->file('medical_cert')->store('renewal_docs', 'public') : null;

        // get user's national id row id (if you need it)
        $nationalId = DB::table('national_id_cards')->where('user_id', $userId)->value('id');

        // create a unique reference for renewal (you can change format)
        $next = DB::table('license_renewals')->max('id') + 1;
        $renewalRef = 'RENEW-' . date('Ymd') . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
        $permitNumber = DB::table('applications')
        ->where('user_id', $userId)
        ->orderByDesc('id')
        ->value('permit_number');
        // insert renewal record
        $renewalId = DB::table('license_renewals')->insertGetId([
            'user_id' => $userId,
            'current_license_number' => $validated['current_license_number'],
            'national_id' => $nationalId,
            'permit_number' => $permitNumber,
            // 'photo' => $photoPath,
            // 'medical_cert' => $medicalPath,
            'delivery_option' => $validated['delivery_option'],
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // redirect to checkout for this renewal
        return redirect()->route('renewal.checkout', ['renewal_id' => $renewalId])
            ->with('success', 'Renewal created. Please complete checkout to pay.');
    }

    /**
     * Show checkout page for a renewal
     */
    public function renewalCheckout(Request $request, $renewal_id)
    {
        $renewal = DB::table('license_renewals')->where('id', $renewal_id)->first();
        if (!$renewal) return redirect()->back()->with('error', 'Renewal not found.');

        $user = DB::table('users')->where('id', $renewal->user_id)->first();

        // compute price for renewal (replace with your actual logic)
        $amount = 60000;
        $currency = 'KHR';
        $permitNumber = DB::table('applications')
        ->where('user_id', $user->id)
        ->value('permit_number');
        // reuse your checkout view — pass renewal_id so pay form posts correctly
        return view('frontend.checkout_payment.checkout', [
            // reuse fields expected by the view
            'permit_number' => $permitNumber,        // reuse permit_number field visually
            'test_date'     => now()->toDateString(),      // placeholder
            'test_time'     => now()->format('H:i:s'),
            'center_name'   => 'N/A - Renewal',
            'amount'        => $amount,
            'currency'      => $currency,
            // additional renewal-specific fields
            'renewal_id'    => $renewal_id,
            'full_name'     => $user->full_name ?? $user->name ?? null,
            'user_email'    => $user->email ?? null,
            'user_phone'    => $user->phone ?? null,
            'license_type'  => 'Renewal',
        ]);
    }

    /**
     * Generate KHQR for renewal and create a payment row.
     * Route: POST /renewal/pay
     */
    public function payKhqrForRenewal(Request $request)
    {
        $data = $request->validate([
            'renewal_id' => 'required|integer',
            'amount' => 'required|integer|min:1',
            'currency' => 'required|in:KHR,USD',
        ]);

        $renewal = DB::table('license_renewals')->where('id', $data['renewal_id'])->first();
        if (!$renewal) return back()->with('error', 'Renewal not found.');

        $user = DB::table('users')->where('id', $renewal->user_id)->first();

        // generate KHQR
        $khqrCurrency = $data['currency'] === 'USD' ? KHQRData::CURRENCY_USD : KHQRData::CURRENCY_KHR;

        $info = new IndividualInfo(
            bakongAccountID: 'e_laihorng@aclb',
            merchantName:    strtoupper($user->full_name ?? $user->name ?? 'MERCHANT'),
            merchantCity:    'Phnom Penh',
            currency:        $khqrCurrency,
            amount:          (int)$data['amount']
        );

        $res = BakongKHQR::generateIndividual($info);

        $resArr = is_array($res) ? $res : (array) $res;
        $inner = $resArr['data'] ?? ($resArr['Data'] ?? []);
        $qrString = $inner['qr'] ?? null;
        $md5 = $inner['md5'] ?? null;

        $png = Builder::create()->data($qrString)->size(320)->margin(10)->build();

        // Save payment row linked to renewal
        $now = Carbon::now();
        $expiresAt = $now->copy()->addMinutes(15);

        $paymentId = DB::table('payments')->insertGetId([
            'user_id' => $renewal->user_id,
            'application_id' => null,
            'renewal_id' => $renewal->id,
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'provider' => 'bakong',
            'provider_payment_id' => null,
            'p_status' => 'pending',
            'khqr_md5' => $md5,
            'khqr_payload' => $qrString,
            'khqr_generated_at' => $now,
            'khqr_expires_at' => $expiresAt,
            'created_at' => now(),
            'paid_at' => null,
        ]);

        // show KHQR page (reuse khqr_card view)
        $permitNumber = DB::table('applications')
        ->where('user_id', $renewal->user_id)
        ->orderByDesc('id')
        ->value('permit_number');
        return view('khqr', [
            'merchant_name' => strtoupper($user->full_name ?? $user->name ?? 'MERCHANT'),
            'amount' => (int)$data['amount'],
            'currency' => $data['currency'] ?? 'KHR',
            'qr_image_base64' => base64_encode($png->getString()),
            'qr_string' => $qrString,
            'md5' => $md5,
            'show_payload' => false,
            'permit_number' => $permit_number??'N/A',
            'expires_at_iso' => $expiresAt->toIso8601String(),
        ]);
    }
     public function checkPayment(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
            'permit_number' => 'required|string',
        ]);

        // find booking + payment
        $booking = DB::table('bookings')->where('permit_number', $request->permit_number)->latest('id')->first();
        if (!$booking) return back()->with('error', 'Booking not found.');

        $payment = DB::table('payments')
            ->where('application_id', $booking->application_id)
            ->where('provider', 'bakong')
            ->where('p_status', 'pending')
            ->latest('id')->first();

        if (!$payment || empty($payment->khqr_md5)) {
            return back()->with('info', 'No pending payment found for this booking.');
        }

        $client = new BakongKHQR(env('BAKONG_TOKEN'));

        try {
            $res = $client->checkTransactionByMD5($payment->khqr_md5);
            $arr = is_array($res) ? $res : (array) $res;
            $inner = $arr['data'] ?? ($arr['Data'] ?? []);
            if (is_object($inner)) $inner = (array)$inner;
            $status = $inner['status'] ?? $inner['Status'] ?? null;

            if ($status && strtoupper($status) === 'SUCCESS') {
                DB::table('payments')->where('id', $payment->id)->update([
                    'p_status' => 'paid',
                    'provider_payment_id' => $inner['transaction_id'] ?? ($inner['tx_id'] ?? $payment->khqr_md5),
                    'paid_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('bookings')->where('id', $booking->id)->update([
                    'b_status' => 'paid',
                    'updated_at' => now(),
                ]);

                return redirect()->route('booking.success', ['permit_number' => $request->permit_number]);
            }

            return back()->with('info', 'Payment not yet confirmed. Please try again later.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Unable to verify payment. ' . $e->getMessage());
        }
    }

    /**
     * AJAX polling endpoint used by khqr_card page.
     */
    public function checkPaymentAjax(Request $request)
    {
        $request->validate(['permit_number' => 'required|string']);

       $booking = DB::table('bookings')->where('permit_number', $request->permit_number)->latest('id')->first();
        if ($booking) {
            $payment = DB::table('payments')->where('application_id', $booking->application_id)->where('provider','bakong')->where('p_status','pending')->latest('id')->first();
        } else {
            // try as renewal reference
            $renewal = DB::table('license_renewals')->where('reference', $request->permit_number)->first();
            if ($renewal) {
                $payment = DB::table('payments')->where('renewal_id', $renewal->id)->where('provider','bakong')->where('p_status','pending')->latest('id')->first();
            } else {
                return response()->json(['status' => 'not_found']);
            }
        }

        // find latest payment for this application/provider
        $payment = DB::table('payments')
            ->where('application_id', $booking->application_id)
            ->where('provider', 'bakong')
            ->latest('id')
            ->first();

        if (!$payment) return response()->json(['status' => 'not_found']);

        // If already marked paid in DB, return paid now
        if (!empty($payment->p_status) && strtolower($payment->p_status) === 'paid') {
            return response()->json(['status' => 'paid']);
        }

        // Check expiry
        if (!empty($payment->khqr_expires_at) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($payment->khqr_expires_at))) {
            return response()->json(['status' => 'expired']);
        }

        // Otherwise call Bakong to verify
        try {
            $client = new BakongKHQR(env('BAKONG_TOKEN'));
            $res = $client->checkTransactionByMD5($payment->khqr_md5);

            // log raw response for debugging
            \Log::info('bakong.checkTransactionByMD5 response', ['res' => $res, 'payment_id' => $payment->id]);

            $arr = is_array($res) ? $res : (array) $res;
            $inner = $arr['data'] ?? ($arr['Data'] ?? []);
            if (is_object($inner)) $inner = (array)$inner;
            $status = $inner['status'] ?? $inner['Status'] ?? null;

            if ($status && strtoupper($status) === 'SUCCESS') {
                DB::table('payments')->where('id', $payment->id)->update([
                    'p_status' => 'paid',
                    'provider_payment_id' => $inner['transaction_id'] ?? ($inner['tx_id'] ?? $payment->khqr_md5),
                    'paid_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('bookings')->where('id', $booking->id)->update([
                    'b_status' => 'paid',
                    'updated_at' => now(),
                ]);

                return response()->json(['status' => 'paid']);
            }

            return response()->json(['status' => 'pending', 'raw' => $inner]);
        } catch (\Throwable $e) {
            \Log::error('checkPaymentAjax error', ['msg' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
