<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Student;

class StudentAuthController extends Controller
{
    public function login()
    {
        return view('student.login');
    }

    public function loginCheck(request $request)
    {
        $user = Student::where('email', $request->email)->first();
        

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('student',  $user->email);
                return redirect()->route('student.dashboard');
            }
            return redirect()->back()->with('error', 'Invalid Email & Password');
        }


        $user = Student::where('enrollment_no', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('student',  $user->email);
                return redirect()->route('student.dashboard');
            }
            return redirect()->back()->with('error', 'Invalid Enrollment No & Password');
        }

        return redirect()->back()->with('error', 'Invalid Email Or Enrollment No');
    }

    public function index()
    {
        return view('student.dashboard');
    }

    public function logout()
    {
        if (Session::has('student')) {
            Session::pull('student');  // logout admin
            return redirect()->route('student.login');
        }
        return redirect()->route('student.login');
    }
}
