<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmailMail;


class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('frontend.users.register');
    }

    public function store(Request $request)
{
    // ✅ Validate input with conditional rules
    $validated = $request->validate([
        'full_name'   => 'required|string|max:255',
        'gender'      => 'required',
        'register_by' => 'required|in:email,phone',
        'dob'         => 'required|date',

        'email' => 'required_if:register_by,email|nullable|email|unique:users,email',
        'phone' => 'required_if:register_by,phone|nullable|string|max:30|unique:users,phone',

        'password' => 'required|string|min:3|confirmed',
    ], [
        'email.required_if' => 'Email is required when registering by email.',
        'phone.required_if' => 'Phone is required when registering by phone.',
        'email.unique'      => 'This email is already registered.',
        'phone.unique'      => 'This phone number is already registered.',
    ]);

    $email = $validated['register_by'] === 'email' ? $validated['email'] : null;
    $phone = $validated['register_by'] === 'phone' ? $validated['phone'] : null;

    if (!$email && !$phone) {
        return back()
            ->withErrors(['register_by' => 'Please provide an email or phone.'])
            ->withInput();
    }

    // ✅ Insert into database
    $userId = DB::table('users')->insertGetId([
        'full_name'     => $validated['full_name'],
        'gender'        => $validated['gender'],
        'email'         => $email,
        'dob'           => $validated['dob'],
        'phone'         => $phone,
        'password_hash' => Hash::make($validated['password']),
        'is_active'     => true,
        'is_verified'   => false,
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);

    // ✅ Attach customer role
    $customerRole = DB::table('roles')->where('name', 'customer')->first();

    if ($customerRole) {
        DB::table('user_roles')->insert([
            'user_id'     => $userId,
            'role_id'     => $customerRole->id,
            'assigned_at' => now(),
        ]);
    }

    // ✅ If registered by email → create token & send verification email
    if ($email) {
        $token = Str::random(64);

        DB::table('email_verifications')->insert([
            'user_id'    => $userId,
            'token'      => $token,
            'expires_at' => now()->addHours(24),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $verifyUrl = route('verify.email', ['token' => $token]);

        Mail::to($email)->send(
            new VerifyEmailMail($validated['full_name'], $verifyUrl)
        );

        // ❌ no auto login here
        return redirect()
            ->route('login') // change to your login route name if different
            ->with('success', 'Registration successful! We sent a verification link to your email. Please verify before logging in.');
    }

    // ✅ If registered by phone → you can auto login (no email verification)
    Auth::loginUsingId($userId);

    return redirect()
        ->route('home')
        ->with('success', 'Registration successful!');
}


    public function verifyEmail(string $token)
    {
        // find verification record
        $record = DB::table('email_verifications')
            ->where('token', $token)
            ->first();

        if (!$record) {
            return redirect()
                ->route('home')
                ->with('error', 'Invalid or already used verification link.');
        }

        // check expiry
        if ($record->expires_at && now()->greaterThan($record->expires_at)) {
            DB::table('email_verifications')->where('id', $record->id)->delete();

            return redirect()
                ->route('home')
                ->with('error', 'This verification link has expired. Please request a new one.');
        }

        // mark user as verified
        DB::table('users')
            ->where('id', $record->user_id)
            ->update([
                'is_verified'        => true,// only if you have this column
                'updated_at'         => now(),
            ]);

        // delete token (one-time use)
        DB::table('email_verifications')->where('id', $record->id)->delete();

        // optionally login
        Auth::loginUsingId($record->user_id);

        return redirect()
            ->route('home')
            ->with('success', 'Your email has been verified successfully.');
    }
}
