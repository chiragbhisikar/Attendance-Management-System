<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FacultyAuthController extends Controller
{
    public function login()
    {
        return view('faculty.login');
    }

    public function loginCheck(request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $faculty = Faculty::where('email', $request->email)->first();
        if ($faculty) {
            if (Hash::check($request->password, $faculty->password)) {
                $request->session()->put('faculty',  $faculty->id);

                return redirect()->route('faculty.dashboard');
            }
            return redirect()->back()->with('error', 'Invalid Email & Password');
        }
        return redirect()->back()->with('error', 'Invalid Email & Password');
    }

    public function logout()
    {
        if (Session::has('faculty')) {
            Session::pull('faculty');  // logout faculty
            return redirect()->route('faculty.login');
        }
        return redirect()->route('faculty.login');
    }
}
