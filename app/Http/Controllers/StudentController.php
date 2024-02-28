<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\TimeTable;
use App\Services\CalendarService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function login()
    {
        return view('student.login');
    }

    public function loginCheck(request $request)
    {
        $user = Student::where('email', $request->email)->where('type', 1)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->route('student.dashboard');
            }
            return redirect()->back()->with('error', 'Invalid Password');
        }
        return redirect()->back()->with('error', 'Invalid Email');
    }

    public function index()
    {
        $now = Carbon::now();
        $date_of_lecture = Carbon::parse($now)->format('Y-m-d');
        $student = Student::where('email', '=', Session::get('student'))->first();
        // $timetables = TimeTable::where('division_id', '=', $student->division_id)->get();

        $lectures = Lecture::join('time_tables', 'lectures.time_table_id', '=', 'time_tables.id')
            ->where('lectures.date_of_lecture', '=', $date_of_lecture)
            ->where('time_tables.division_id', '=', $student->division_id)
            ->select('lectures.*')
            ->orderBy('time_tables.start_time', 'ASC')
            ->get();

        return view('student.dashboard', compact('lectures', 'date_of_lecture', 'student'));
    }

    public function giveAttendance(Request $request)
    {
        $lectureDetail = Lecture::where('slug', '=', $request->lecture)->first();
        if (!$lectureDetail) {
            return redirect(route('student.dashboard'));
        }

        return view('student.attendance.give-attendance', compact('lectureDetail'));
    }

    public function saveAttendance(Request $request)
    {
        $lectureDetail = Lecture::where('slug', '=', $request->lecture)->first();
        if (!$lectureDetail) {
            return redirect(route('student.dashboard'))->with('error', 'Invalid Lecture !');
        }

        $now = Carbon::now();
        $time = Carbon::parse($now)->timezone('+5:30')->format('H:i:s');

        if ($lectureDetail->otp != $request->otp && $lectureDetail->is_open != true) {
            return redirect(route('student.dashboard'))->with('error', 'Wrong OTP !');
        }

        if (
            $lectureDetail->otp == $request->otp && $lectureDetail->is_open == true &&
            ($time > $lectureDetail->start_time && $time < $lectureDetail->end_time)
        ) {


            $student = Student::where('email', '=', Session::get('student'))->first();

            $attendance = new Attendance();
            $attendance->student_id = $student->id;
            $attendance->lecture_id = $lectureDetail->id;
            $attendance->latitude = 62.75;
            $attendance->longitude = 154.14;
            $attendance->save();

            return redirect(route('student.dashboard'))->with('success', 'Attended Successfully !');
        }
        return redirect(route('student.dashboard'));
    }

    public function viewTimeTable(CalendarService $calendarService)
    {
        $student = Student::where('email', '=', Session::get('student'))->first();

        $division = $student->division_id;
        $weekDays     = TimeTable::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays);

        return view('student.time-table.view', compact('weekDays', 'calendarData'));
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::logout(); // logout admin
            return redirect()->route('student.login');
        }
    }
}
