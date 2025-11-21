<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use KHQR\BakongKHQR;          // ✅ add this
use KHQR\Helpers\KHQRData;    // ✅ add this
use KHQR\Models\IndividualInfo; // ✅ add this
use Endroid\QrCode\Builder\Builder; // ✅ add this

class BakongController extends Controller
{
    /**
     * Generate KHQR payment code
     */
    public function generateQR(Request $request)
    {
        $amount = (int) $request->input('amount', 15000); // default 15000 riel
        $currency = $request->input('currency', KHQRData::CURRENCY_KHR);

        $info = new IndividualInfo(
            bakongAccountID: 'e_laihorng@aclb', // your Bakong account ID
            merchantName:    'ELICENSE.GOV',        // your shop name
            merchantCity:    'Phnom Penh',
            currency:        $currency,
            amount:          $amount
        );

        $response = BakongKHQR::generateIndividual($info);

        $qrString = $response->data['qr'];
        $md5 = $response->data['md5'];

        // Build QR image as base64 PNG
        $png = Builder::create()
            ->data($qrString)
            ->size(300)
            ->margin(10)
            ->build();

        return view('khqr', [
            'qr_image_base64' => base64_encode($png->getString()),
            'qr_string' => $qrString,
            'md5' => $md5,
        ]);

    }

    /**
     * Check transaction by MD5
     */
    public function checkTransaction(Request $request)
    {
        $md5 = $request->input('md5');

        if (!$md5) {
            return response()->json(['error' => 'Missing md5 parameter'], 400);
        }

        $token = env('BAKONG_TOKEN');
        $bakong = new BakongKHQR($token);
        $status = $bakong->checkTransactionByMD5($md5);

        return response()->json($status);
    }
}
