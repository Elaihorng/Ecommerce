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
        // ✅ Validate input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required',
            'register_by' => 'required|in:email,phone',
            'dob' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:30|unique:users,phone',
            'password' => 'required|string|min:3|confirmed',
        ]);

        // ✅ Prepare fields
        $email = $validated['register_by'] === 'email' ? $validated['email'] : null;
        $phone = $validated['register_by'] === 'phone' ? $validated['phone'] : null;

        // ✅ Insert into database
        $userId = DB::table('users')->insertGetId([
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'email' => $email,
            'dob' => $validated['dob'],
            'phone' => $phone,
            'password_hash' => Hash::make($validated['password']),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $customerRole = DB::table('roles')->where('name', 'customer')->first();

        if ($customerRole) {
            DB::table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $customerRole->id,
                'assigned_at' => now(),
            ]);
        }
        // ✅ Auto-login
        Auth::loginUsingId($userId);

        // ✅ Redirect
        return redirect()->route('home')->with('success', 'Registration successful! Welcome aboard.');
    }
    
}


