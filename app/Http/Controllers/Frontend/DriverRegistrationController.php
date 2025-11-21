<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DriverPermitIssuedMail;
class DriverRegistrationController extends Controller
{
    public function showRegisterForm()
    {
        // Fetch all license types from the DB
        $licenseTypes = DB::table('license_types')->get();

        // Pass to Blade
        return view('frontend.service.register', compact('licenseTypes'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'license_type'  => 'required|exists:license_types,code',
            'test_center'   => 'required|string|max:100',
            'test_date'     => 'required|date',
            'national_id'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'photo'         => 'required|file|mimes:jpg,jpeg,png|max:3072',
        ]);
 

        // ✅ Step 3: Generate permit number (unique)

        $userId = Auth::check()
            ? Auth::id()
            : DB::table('users')->insertGetId([
                'full_name' => $validated['full_name'],
                'password_hash' => Hash::make('123456'), // default
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // Step 2: National ID
        $user = DB::table('users')->where('id', $userId)->first();
        $nidPath = $request->file('national_id')->store('driver_docs', 'public');
        $nationalIdId = DB::table('national_id_cards')->insertGetId([
            'user_id' => $userId,
            'khmer_id' => 'KH-' . strtoupper(uniqid()),
            'place_of_issue' => $validated['test_center'],
            'date_of_birth' => $user->dob,
            'gender' => $user->gender,
            'created_at' => now(),
        ]);

        // Step 3: Create application

        // Step 4: Auto book test
        $testCenter = DB::table('test_centers')
            ->where('name', $validated['test_center'])
            ->first();

        if (!$testCenter) {
            $testCenterId = DB::table('test_centers')->insertGetId([
                'name' => $validated['test_center'],
                'address' => 'Unknown Address', // or add from form later
                'city' => ucfirst($validated['test_center']),
                'contact_phone' => $user->phone,
                'created_at' => now(),
            ]);
        } else {
            $testCenterId = $testCenter->id;
        }
        $nextAppId = DB::table('applications')->max('id') + 1;
        $permitNumber = 'PERMIT-' . date('Ymd') . '-' . str_pad($nextAppId, 4, '0', STR_PAD_LEFT);
        
        $applicationId = DB::table('applications')->insertGetId([
            'user_id' => $userId,
            'national_id_id' => $nationalIdId,
            'test_center_id' => $testCenterId,
            'permit_number' => $permitNumber,
            'application_type' => 'new',
            'requested_license_type' => $validated['license_type'],
            'app_status' => 'submitted',
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

       

        $user = DB::table('users')->where('id', $userId)->first();

        if (!empty($user->email)) {
            Mail::to($user->email)->send(new DriverPermitIssuedMail($user->full_name, $permitNumber));
        }
        return redirect()->route('booktest')
            ->with('success', '✅ Registration successful! Next, book your test date. Please check Permit number on ur email!');

    
    }

}
