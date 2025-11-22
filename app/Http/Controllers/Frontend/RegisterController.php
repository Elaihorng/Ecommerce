<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        // if register_by = email → email is required + must be unique
        'email' => 'required_if:register_by,email|nullable|email|unique:users,email',

        // if register_by = phone → phone is required + must be unique
        'phone' => 'required_if:register_by,phone|nullable|string|max:30|unique:users,phone',

        'password' => 'required|string|min:3|confirmed',
    ], [
        // optional: nicer messages
        'email.required_if' => 'Email is required when registering by email.',
        'phone.required_if' => 'Phone is required when registering by phone.',
        'email.unique'      => 'This email is already registered.',
        'phone.unique'      => 'This phone number is already registered.',
    ]);

    // ✅ Prepare fields based on register_by
    $email = $validated['register_by'] === 'email' ? $validated['email'] : null;
    $phone = $validated['register_by'] === 'phone' ? $validated['phone'] : null;

    // (extra safety – should not happen if validation is correct)
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

    // ✅ Auto login
    Auth::loginUsingId($userId);

    return redirect()
        ->route('home')
        ->with('success', 'Registration successful! Welcome aboard.');
}

}


