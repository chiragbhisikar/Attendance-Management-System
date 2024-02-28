<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Imports\TimetableImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Division;
use App\Models\TimeTable;

class FrontController extends Controller
{
    public function index()
    {
        return view('welcome');
        // return Excel::download(new AttendanceExport, 'faculty.xlsx');
    }

    // public function test()
    // {
    //     $students = Student::where('division_id', '=', 1)->get();
    //     $attendeeData = [];

    //     $attendanceData = Attendance::with(['lecture', 'student'])
    //         ->select('student_id', 'lecture_id', 'created_at')
    //         ->get();

    //     $count_attendanace = 0;
    //     $total_student = 0;

    //     foreach ($students as $student) {
    //         $name = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
    //         $rowData = ['enrollment_no' => $student->enrollment_no, 'name' => $name];


    //         $attendance = $attendanceData
    //             ->where('student_id', $student->id)
    //             ->where('lecture_id', '=', 3)
    //             ->first();

    //         $rowData['status'] = $attendance ? 'P' : 'A';

    //         if ($attendance) {
    //             $count_attendanace = $count_attendanace + 1;
    //         }
    //         $total_student = $total_student + 1;

    //         // $rowData[] =  (string)$total_lecture;
    //         // $rowData[] = (string)(($count_present * 100) / $total_lecture) . '%';
    //         array_push($attendeeData, $rowData);
    //     }

    //     $lectureData = [
    //         'count_attendanace' => (string)$count_attendanace,
    //         'total_student' => (string)$total_student,
    //         'count_present' => (string)(($count_attendanace * 100) / $total_student) . '%',
    //     ];

    //     // dd($attendeeData);
    //     return view('admin.attendance.index', compact('attendeeData', 'lectureData'));
    // }

    // public function importTimetable(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,csv',
    //     ]);

    //     $file = $request->file('file');

    //     Excel::import(new TimetableImport, $file);

    //     return redirect()->route('timetable.index')->with('success', 'Timetable imported successfully');
    // }

    public function test()
    {
        // return Excel::download(new AttendanceExport, 'faculty.xlsx');
        return view('test');
    }
    public function importTimetable(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'division_id' => 'required|numeric',
            'term_start_date' => 'required|date',
            'term_end_date' => 'required|date',
        ]);


        $division = $request->division_id;
        $sem = Division::find($division)->current_sem;
        $term_start_date = $request->term_start_date;
        $term_end_date = $request->term_end_date;

        $file = $request->file('file');
        $res = Excel::import(new TimetableImport($division, $sem, $term_start_date, $term_end_date), $file);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
