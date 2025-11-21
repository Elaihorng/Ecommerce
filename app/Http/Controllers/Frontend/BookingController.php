<?php

namespace App\Http\Controllers\frontend;

use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first to book your test.');
        }

        $validated = $request->validate([
            'permit_number' => 'required|string|max:100',
            'test_date' => 'required|date|after_or_equal:today',
            'test_time' => 'required|date_format:H:i',
        ]);

        $application = DB::table('applications')
            ->where('permit_number', $validated['permit_number'])
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Permit number not found. Please check again.');
        }

        $slot = DB::table('test_slots')
            ->where('center_id', $application->test_center_id)
            ->where('slot_date', $validated['test_date'])
            ->where('start_time', $validated['test_time'])
            ->first();

        if (!$slot) {
            $slotId = DB::table('test_slots')->insertGetId([
                'center_id' => $application->test_center_id,
                'slot_date' => $validated['test_date'],
                'start_time' => $validated['test_time'],
                'end_time' => date('H:i:s', strtotime($validated['test_time'] . ' +1 hour')),
                'capacity' => 10,
                'created_at' => now(),
            ]);
        } else {
            $slotId = $slot->id;
        }

        $bookingId = DB::table('bookings')->insertGetId([
            'application_id' => $application->id,
            'user_id' => Auth::id(),
            'test_center_id' => $application->test_center_id,
            'slot_id' => $slotId,
            'permit_number' => $application->permit_number,
            'b_status' => 'pending',
            'test_date' => $validated['test_date'],
            'test_time' => $validated['test_time'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')
        ->where('id', Auth::id())
        ->update(['permit_number' => $application->permit_number]);

        return redirect()
            ->route('booking.checkout', ['permit_number' => $application->permit_number])
            ->with('success', 'Booking created. Review and confirm payment.');
    }

    public function checkout(Request $request)
    {
        $request->validate(['permit_number' => 'required|string|max:100']);

        $booking = DB::table('bookings')
            ->where('permit_number', $request->permit_number)
            ->latest('id')
            ->first();

        if (!$booking) {
            return back()->with('error', 'Booking not found.');
        }

        $application = DB::table('applications')
            ->where('permit_number', $booking->permit_number)
            ->first();

        if (!$application) {
            return back()->with('error', 'Application not found.');
        }

        $user = DB::table('users')->where('id', $application->user_id)->first();

        $licenseTypeRow = DB::table('license_types')
            ->where('code', $application->requested_license_type)
            ->first();
        $licenseTypeName = $licenseTypeRow->name ?? $application->requested_license_type;

        $center = DB::table('test_centers')->where('id', $booking->test_center_id)->first();

        // fee logic — change as needed
        $amount = 100;
        $currency = 'KHR';

        $fullName = $user->full_name ?? $user->name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $gender = $user->gender ?? DB::table('national_id_cards')->where('user_id', $user->id)->value('gender');

        return view('frontend.checkout_payment.checkout', [
            'permit_number'     => $booking->permit_number,
            'test_date'         => $booking->test_date,
            'test_time'         => $booking->test_time,
            'center_name'       => $center->name ?? 'Unknown Center',
            'amount'            => $amount,
            'currency'          => $currency,
            'full_name'         => $fullName ?? null,
            'gender'            => $gender ?? null,
            'application_type'  => $application->application_type ?? null,
            'license_type'      => $licenseTypeName,
            'user_email'        => $user->email ?? null,
            'user_phone'        => $user->phone ?? null,
        ]);
    }

    /**
     * Generate KHQR, create a payment record, and show QR page.
     */
   /**
 * Unified pay handler for both booking (permit_number) and renewal (renewal_id).
 * Called from the checkout form.
 */
   public function payKhqr(Request $request)
    {
        // Accept either renewal_id OR permit_number
        $data = $request->validate([
            'renewal_id'    => 'nullable|integer',
            'permit_number' => 'nullable|string|max:200',
            'amount'        => 'required|integer|min:1',
            'currency'      => 'required|in:KHR,USD',
        ]);

        // Decide flow
        $isRenewal = !empty($data['renewal_id']);
        $isBooking = !empty($data['permit_number']);

        if (! $isRenewal && ! $isBooking) {
            return back()->with('error', 'Missing permit number or renewal id.');
        }

        // Locate target (booking/application) or renewal
        $booking = null;
        $application = null;
        $renewal = null;
        if ($isBooking) {
            $booking = DB::table('bookings')->where('permit_number', $data['permit_number'])->latest('id')->first();
            if (!$booking) {
                return back()->with('error', 'Booking not found for permit number.');
            }
            $application = DB::table('applications')->where('id', $booking->application_id)->first();
            $userId = $booking->user_id ?? $application->user_id ?? auth()->id();
        } else {
            $renewal = DB::table('license_renewals')->where('id', $data['renewal_id'])->first();
            if (!$renewal) {
                return back()->with('error', 'Renewal not found.');
            }
            $userId = $renewal->user_id;
            // try to use permit_number saved on renewal or from user's application
            $data['permit_number'] = $renewal->permit_number ?? DB::table('applications')->where('user_id', $userId)->orderByDesc('id')->value('permit_number');
        }

        // Get user for merchant label
        $user = DB::table('users')->where('id', $userId)->first();

        // ---------------------------
        // Check for existing pending payment (do not recreate)
        // ---------------------------
        $now = Carbon::now();
        $existingQuery = DB::table('payments')
            ->where('user_id', $userId)
            ->where('provider', 'bakong')
            ->where('p_status', 'pending')
            ->orderByDesc('id');

        if (!empty($application->id)) {
            $existingQuery->where('application_id', $application->id);
        } elseif (!empty($renewal->id)) {
            $existingQuery->where('renewal_id', $renewal->id);
        }

        $existingPayment = $existingQuery->first();

        if ($existingPayment) {
            // If it has an expiry and is still valid, reuse it
            $expiresAt = null;
            if (!empty($existingPayment->khqr_expires_at)) {
                $expiresAt = Carbon::parse($existingPayment->khqr_expires_at);
            }

            if ($expiresAt && $now->lessThanOrEqualTo($expiresAt)) {
                // Reuse existing pending payment — rebuild PNG from stored payload
                $payload = $existingPayment->khqr_payload ?? '';
                if (!empty($payload) && strlen($payload) > 20) {
                    $png = Builder::create()->data($payload)->size(320)->margin(10)->build();

                    $permitNumber = $data['permit_number'] ?? ($renewal->permit_number ?? null);

                    return view('khqr', [
                        'merchant_name' => strtoupper($user->full_name ?? $user->name ?? 'MERCHANT'),
                        'amount' => (int)$data['amount'],
                        'currency' => $data['currency'] ?? 'KHR',
                        'qr_image_base64' => base64_encode($png->getString()),
                        'qr_string' => $payload,
                        'md5' => $existingPayment->khqr_md5,
                        'show_payload' => false,
                        'permit_number' => $permitNumber ?? 'N/A',
                        'expires_at_iso' => $expiresAt->toIso8601String(),
                    ]);
                }
                // otherwise fall through to regenerate
            }
            // existing found but expired -> fall through to generate new
        }

        // ---------------------------
        // Generate new KHQR payload
        // ---------------------------
        $khqrCurrency = $data['currency'] === 'USD' ? KHQRData::CURRENCY_USD : KHQRData::CURRENCY_KHR;

        $info = new IndividualInfo(
            bakongAccountID: 'e_laihorng@aclb',
            merchantName:    strtoupper($user->full_name ?? $user->name ?? 'MERCHANT'),
            merchantCity:    'Phnom Penh',
            currency:        $khqrCurrency,
            amount:          (int)$data['amount']
        );

        $res = BakongKHQR::generateIndividual($info);

        // Safely extract response
        $resArr = is_array($res) ? $res : (array) $res;
        $inner = $resArr['KHQRResponse'] ?? $resArr['data'] ?? ($resArr['Data'] ?? []);
        if (is_object($inner)) $inner = (array) $inner;
        $qrString = $inner['qr'] ?? $inner['QR'] ?? null;
        $md5 = $inner['md5'] ?? $inner['MD5'] ?? $inner['hash'] ?? null;

        if (empty($qrString) || empty($md5)) {
            \Log::error('Failed to generate QR from Bakong', ['res' => $res, 'user_id' => $userId]);
            return back()->with('error', 'Failed to generate QR from Bakong.');
        }

        // Build PNG
        $png = Builder::create()->data($qrString)->size(320)->margin(10)->build();

        // Create payment record, linking to application_id OR renewal_id
        $expiresAt = $now->copy()->addMinutes(15);

        $paymentId = DB::table('payments')->insertGetId([
            'user_id' => $userId,
            'application_id' => $application->id ?? null,
            'renewal_id' => $renewal->id ?? null,
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

        \Log::info('Created new payment', ['payment_id' => $paymentId, 'user_id' => $userId, 'application_id' => $application->id ?? null, 'renewal_id' => $renewal->id ?? null]);

        // Return KHQR view. permit_number was prepared above for either flow.
        $permitNumber = $data['permit_number'] ?? ($renewal->permit_number ?? null);

        return view('khqr', [
            'merchant_name' => strtoupper($user->full_name ?? $user->name ?? 'MERCHANT'),
            'amount' => (int)$data['amount'],
            'currency' => $data['currency'] ?? 'KHR',
            'qr_image_base64' => base64_encode($png->getString()),
            'qr_string' => $qrString,
            'md5' => $md5,
            'show_payload' => false,
            'permit_number' => $permitNumber ?? 'N/A',
            'expires_at_iso' => $expiresAt->toIso8601String(),
        ]);
    }

    /**
     * Manual check triggered by form (keeps old behavior).
     */
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

    \Log::info('bakong.checkTransactionByMD5 response', ['res' => $res, 'payment_id' => $payment->id]);

    // Normalize to array and find the most relevant fields
    $arr = is_array($res) ? $res : (array) $res;

    // If provider returns envelope keys like responseCode/responseMessage and data
    $responseCode = $arr['responseCode'] ?? $arr['ResponseCode'] ?? null;
    $responseMessage = $arr['responseMessage'] ?? $arr['ResponseMessage'] ?? null;
    $inner = $arr['data'] ?? ($arr['Data'] ?? []);

    if (is_object($inner)) $inner = (array) $inner;

    // Extract useful fields
    $hash = $inner['hash'] ?? $inner['md5'] ?? $inner['khqr_md5'] ?? null;
    $txid = $inner['externalRef'] ?? $inner['transaction_id'] ?? $inner['tx_id'] ?? null;
    $ackMs = $inner['acknowledgedDateMs'] ?? $inner['ackMs'] ?? null;

    \Log::info('bakong.parsed', [
        'responseCode' => $responseCode,
        'responseMessage' => $responseMessage,
        'hash' => $hash,
        'txid' => $txid,
        'ackMs' => $ackMs,
        'payment_id' => $payment->id
    ]);

    // Decide success: provider indicates success when responseCode === 0 OR responseMessage contains 'success'
    $isSuccess = false;
    if ($responseCode !== null && (int)$responseCode === 0) $isSuccess = true;
    if (! $isSuccess && $responseMessage !== null && stripos((string)$responseMessage, 'success') !== false) $isSuccess = true;
    // Also treat presence of acknowledgedDateMs (acknowledged timestamp) as success
    if (! $isSuccess && !empty($ackMs)) $isSuccess = true;

    if ($isSuccess) {
        DB::table('payments')->where('id', $payment->id)->update([
            'p_status' => 'paid',
            'provider_payment_id' => $txid ?? $payment->provider_payment_id ?? $payment->khqr_md5,
            'paid_at' => now(),
            'updated_at' => now(),
        ]);

        // // Update booking: prefer booking (if present), else use application_id, else renewal_id
        // if (!empty($booking) && !empty($booking->id)) {
        //     DB::table('bookings')->where('id', $booking->id)->update([
        //         'b_status' => 'paid',
        //         'updated_at' => now(),
        //     ]);
        // } elseif (!empty($payment->application_id)) {
        //     DB::table('bookings')->where('application_id', $payment->application_id)->update([
        //         'b_status' => 'paid',
        //         'updated_at' => now(),
        //     ]);
        // } elseif (!empty($payment->renewal_id)) {
        //     DB::table('license_renewals')->where('id', $payment->renewal_id)->update([
        //         'status' => 'paid',
        //         'updated_at' => now(),
        //     ]);
        // }

        \Log::info('Payment marked paid (via checkTransactionByMD5)', ['payment_id' => $payment->id, 'txid' => $txid]);
        return response()->json(['status' => 'paid']);
    }

    // Not successful yet: return pending with parsed info for debugging
    return response()->json(['status' => 'pending', 'raw' => $inner]);
} catch (\Throwable $e) {
    \Log::error('checkPaymentAjax exception', ['msg' => $e->getMessage(), 'payment_id' => $payment->id ?? null]);
    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
}

    }
    public function history()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in to view your booking history.');
        }

        // Subquery: latest payment per application
        $lastPayments = DB::raw('(
            SELECT p1.*
            FROM payments p1
            JOIN (
                SELECT application_id, MAX(id) AS max_id
                FROM payments
                GROUP BY application_id
            ) px ON p1.application_id = px.application_id AND p1.id = px.max_id
        ) AS last_payments');

        // Subquery: latest test_result per booking
        $lastTests = DB::raw('(
            SELECT t1.*
            FROM test_results t1
            JOIN (
                SELECT booking_id, MAX(id) AS max_id
                FROM test_results
                GROUP BY booking_id
            ) tx ON t1.booking_id = tx.booking_id AND t1.id = tx.max_id
        ) AS last_tests');

        $bookings = DB::table('bookings')
            ->leftJoin('applications', 'bookings.application_id', '=', 'applications.id')
            ->leftJoin('test_centers', 'bookings.test_center_id', '=', 'test_centers.id')
            ->leftJoin($lastPayments, function ($join) {
                $join->on('applications.id', '=', 'last_payments.application_id');
            })
            ->leftJoin($lastTests, function ($join) {
                $join->on('bookings.id', '=', 'last_tests.booking_id');
            })
            ->where('bookings.user_id', $userId)
            ->select(
                'bookings.id as booking_id',
                'bookings.permit_number',
                'bookings.test_date',
                'bookings.test_time',
                'bookings.b_status',
                'applications.application_type',
                'applications.requested_license_type',
                'test_centers.name as center_name',
                'last_payments.p_status as payment_status',
                'last_payments.amount as payment_amount',
                'last_payments.currency as payment_currency',
                'last_tests.theory_result',
                'last_tests.practical_result'
            )
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('frontend.booking.history', compact('bookings'));
    }


    /**
     * Optional success view helper — route can point to this.
     */
    public function successView($permit_number)
    {
        return view('frontend.checkout_payment.success', compact('permit_number'));
    }
}
