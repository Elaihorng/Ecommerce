<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.users.index');
    }

    public function register(){
        return view('frontend.users.register');
    }

     public function profile()
    {
        $user = Auth::user(); // get logged-in user
        return view('frontend.users.profile', compact('user'));
    }
}
