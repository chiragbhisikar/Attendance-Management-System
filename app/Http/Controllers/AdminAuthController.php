<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginCheck(request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('admin',  $user->email);
                return redirect()->route('admin.dashboard');
            }
            return redirect()->back()->with('error', 'Invalid Email & Password');
        }
        return redirect()->back()->with('error', 'Invalid Email & Password');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        if (Session::has('admin')) {
            Session::pull('admin');  // logout admin
            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.login');
    }
}
