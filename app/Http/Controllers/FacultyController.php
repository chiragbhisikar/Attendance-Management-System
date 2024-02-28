<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Division;
use App\Models\Faculty;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\TimeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $date_of_lecture = Carbon::parse($now)->format('Y-m-d');
        $faculty_id = Session::get('faculty');
        $faculty = Faculty::select('first_name', 'last_name', 'middle_name')->find($faculty_id);

        // $lectures = Lecture::join('time_tables', 'lectures.time_table_id', '=', 'time_tables.id')
        //     ->join('faculty_lecturers', 'time_tables.id', '=', 'faculty_lecturers.time_table_id')
        //     ->where('lectures.date_of_lecture', '=', $date_of_lecture)
        //     ->where('faculty_lecturers.faculty_id', '=', $faculty_id)
        //     ->select('lectures.start_time', 'lectures.end_time', 'lectures.slug', 'lectures.otp', 'lectures.is_open', 'faculty_lecturers.*')
        //     ->orderBy('time_tables.start_time', 'ASC')
        //     ->get();

        $lectures = TimeTable::join('lectures', 'lectures.time_table_id', '=', 'time_tables.id')
            ->join('faculty_lecturers', 'time_tables.id', '=', 'faculty_lecturers.time_table_id')
            ->where('lectures.date_of_lecture', '=', $date_of_lecture)
            ->where('faculty_lecturers.faculty_id', '=', $faculty_id)
            ->select('lectures.*','faculty_lecturers.lab_name')
            ->orderBy('time_tables.start_time', 'ASC')
            ->get();


        return view('faculty.dashboard', compact('lectures', 'date_of_lecture', 'faculty'));
    }

    public function attendance()
    {
        $faculty_id = Session::get('faculty');
        $faculty = Faculty::select('first_name', 'last_name', 'middle_name', 'department_id')->find($faculty_id);
        $divisions = Division::where('department_id', '=', $faculty->department_id)->get();
        $subjects = Subject::where('department_id', '=', $faculty->department_id)->get();

        return view('faculty.attendance.index', compact('faculty', 'divisions', 'subjects'));
    }

    public function exportAttendance(Request $request)
    {
        $request->validate([
            'division' => 'required|numeric',
            'subject' => 'required|numeric',
        ]);
        $division_id = $request->division;
        $subject_id = $request->subject;

        $timetables = TimeTable::select('id')->where('division_id', $division_id)->where('subject_id', $subject_id)->first();

        if ($timetables == null) {
            return redirect()->route('faculty.attendance')->with('error', 'No Lectures Found !');
        }
        return Excel::download(new AttendanceExport($division_id, $subject_id), 'attendance.xlsx');
    }

    public function rescheduleLecture(Request $request)
    {
        $request->validate([
            'lecture' => 'required',
        ]);

        $faculty_id = Session::get('faculty');
        $faculty = Faculty::select('first_name', 'last_name', 'middle_name')->find($faculty_id);
        $lecture = Lecture::where('slug', '=', $request->lecture)->first();

        if ($lecture) {
            return view('faculty.lecture.reschedule-lecture', compact('faculty', 'lecture'));
        } else {
            return redirect()->back();
        }
    }

    public function saveRescheduleLecture(Request $request)
    {
        $request->validate([
            'lecture' => 'required',
            'lecture_start_time' => 'required',
            'lecture_end_time' => 'required',
        ]);

        if ($request->lecture_start_time >= $request->lecture_end_time) {
            return redirect()->back()->with('error', 'Enter Valid Time !');
        }
        $lecture = Lecture::where('slug', '=', $request->lecture)->first();
        if ($lecture) {
            $lecture->start_time = $request->lecture_start_time;
            $lecture->end_time = $request->lecture_end_time;
            $lecture->otp = rand(111111, 999999);
            $lecture->save();
        } else {
            return redirect()->route('faculty.dashboard');
        }
        return redirect()->route('faculty.dashboard');
    }

    function takeAttendance(Request $request)
    {
        $request->validate([
            'lecture' => 'required',
        ]);

        $faculty_id = Session::get('faculty');
        $faculty = Faculty::select('first_name', 'last_name', 'middle_name')->find($faculty_id);
        $lecture = Lecture::where('slug', '=', $request->lecture)->first();

        if ($lecture) {
            return view('faculty.attendance.take-attendance', compact('faculty', 'lecture'));
        } else {
            return redirect()->back();
        }
    }

    function controlLecture(Request $request)
    {
        $lecture = Lecture::find($request->lecture_id);
        if ($lecture->is_open == "0") {
            $lecture->is_open = true;
            $lecture->update();
        } else {
            $lecture->is_open = false;
            $lecture->update();
        }

        return response([
            "status" => 400,
            "data" => $request->all(),
        ]);
    }
}
