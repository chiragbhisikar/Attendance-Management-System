<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Session;
use App\Services\CalendarService;


use App\Models\User;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Department;
use App\Models\DepartmentType;
use App\Models\Division;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\TimeTable;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // Faculty 
    public function faculty()
    {
        $faculties = Faculty::paginate(10);
        $departments = Department::get();
        $department_id = 0;
        return view('admin.faculty.index', compact('faculties', 'departments', 'department_id'));
    }

    // Add Faculty 
    public function addFaculty()
    {
        $departments = Department::get();
        return view('admin.faculty.add', compact('departments'));
    }



    public function saveFaculty(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'short_name' => 'required|unique:faculties,short_name',
            'email' => 'required|unique:faculties|email',
            'phone_number' => 'required',
            'department_id' => 'required',
            'password' => 'required',
        ]);

        try {
            $faculty = new Faculty();
            $faculty->first_name = $request->first_name;
            $faculty->last_name = $request->last_name;
            $faculty->middle_name = $request->middle_name;
            $faculty->short_name = $request->short_name;
            $faculty->email = $request->email;
            $faculty->phone_number = $request->phone_number;
            $faculty->department_id = $request->department_id;
            $faculty->password = Hash::make($request->password);
            $faculty->save();

            if ($faculty) {
                $d = [
                    'email' => $faculty->email,
                ];

                $data = [
                    'password' => $request->password,
                ];

                Mail::send(
                    'admin.mail',
                    $data,

                    function ($message) use ($d) {
                        // dd( $d );
                        $message->to($d['email'], 'Reset Password')->subject('Reset Your Password');

                        $message->from('ldce@gmail.com', 'LDCE');
                    }
                );
            }

            return redirect(route('admin.faculty'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Edit Faculty 
    public function editFaculty(Request $request)
    {
        $faculty = Faculty::find($request->faculty_id);
        $departments = Department::get();
        return view('admin.faculty.edit', compact('faculty', 'departments'));
    }

    public function updateFaculty(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'short_name' => 'required|unique:faculties|short_name',
            'middle_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'department_id' => 'required',
        ]);

        try {
            $faculty = Faculty::find($request->faculty_id);
            $faculty->first_name = $request->first_name;
            $faculty->last_name = $request->last_name;
            $faculty->middle_name = $request->middle_name;
            $faculty->short_name = $request->short_name;
            $faculty->email = $request->email;
            $faculty->phone_number = $request->phone_number;
            $faculty->department_id = $request->department_id;
            $faculty->save();

            return redirect(route('admin.faculty'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function forgetPasswordFaculty(Request $request)
    {
        $faculty = Faculty::find($request->faculty_id);
        return view('admin.faculty.forgot-password', compact('faculty'));
    }

    public function updatePasswordFaculty(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required',
            'password' => 'required',
            'confirm_password' => 'same:password',
        ]);
        try {
            $faculty = Faculty::find($request->faculty_id);
            $faculty->password = Hash::make($request->password);
            $faculty->save();

            if ($faculty) {
                $d = [
                    'email' => $faculty->email,
                ];

                $data = [
                    'password' => $request->password,
                ];

                Mail::send(
                    'admin.mail',
                    $data,

                    function ($message) use ($d) {
                        // dd( $d );
                        $message->to($d['email'], 'Reset Password')->subject('Reset Your Password');

                        $message->from('ldce@gmail.com', 'LDCE');
                    }
                );
            }

            return redirect(route('admin.faculty'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Filter Faculty
    public function filterFaculty(Request $request)
    {
        $request->validate([
            'department' => 'required|numeric',
        ]);

        $faculties = Faculty::where('department_id', '=', $request->department)->with('department')->paginate(10);
        $department_id = $request->department;
        $departments = Department::get();

        return view('admin.faculty.index', compact('faculties', 'departments', 'department_id'));
    }

    // Subject
    public function subject()
    {
        $subjects = Subject::paginate(10);
        $departments = Department::get();
        return view('admin.subject.index', compact('subjects', 'departments'));
    }

    public function addSubject(Request $request)
    {
        $departments = Department::get();
        return view('admin.subject.add', compact('departments'));
    }

    public function saveSubject(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'short_name' => 'required',
            'code' => 'required|numeric',
            'sem' => 'required|numeric',
            'department_id' => 'required',
        ]);

        try {
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->short_name = $request->short_name;
            $subject->code = $request->code;
            $subject->sem = $request->sem;
            $subject->department_id = $request->department_id;
            $subject->save();

            return redirect(route('admin.subject'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editSubject(Request $request)
    {
        $subject = Subject::find($request->subject_id);
        $departments = Department::get();
        return view('admin.subject.edit', compact('subject', 'departments'));
    }

    public function updateSubject(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'name' => 'required',
            'short_name' => 'required',
            'code' => 'required|numeric',
            'sem' => 'required|numeric',
            'department_id' => 'required',
        ]);

        try {
            $subject = Subject::find($request->subject_id);
            $subject->name = $request->name;
            $subject->short_name = $request->short_name;
            $subject->code = $request->code;
            $subject->sem = $request->sem;
            $subject->department_id = $request->department_id;
            $subject->save();

            return redirect(route('admin.subject'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filterSubject(Request $request)
    {
        $request->validate([
            'department' => 'numeric',
            'sem' => 'numeric',
        ]);

        $subjects = Subject::where('department_id', '=', $request->department)->with('department')->paginate(10);
        $department_id = $request->department;
        $departments = Department::get();

        return view('admin.subject.index', compact('subjects', 'departments', 'department_id'));
    }

    // Department
    public function department()
    {
        $departments = Department::orderBy('department_code')->paginate(20);
        return view('admin.department.index', compact('departments'));
    }

    public function addDepartment(Request $request)
    {
        $department_types = DepartmentType::get();
        return view('admin.department.add', compact('department_types'));
    }

    public function saveDepartment(Request $request)
    {
        $request->validate([
            'department_type_id' => 'required|numeric',
            'branch_code' => 'required||numeric',
            'branch_name' => 'required',
        ]);

        try {
            $branch = new Department();
            $branch->department_type_id = $request->department_type_id;
            $branch->department_code = $request->branch_code;
            $branch->department_name = $request->branch_name;
            $branch->save();

            return redirect(route('admin.branch'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editDepartment(Request $request)
    {
        $department_types = DepartmentType::get();
        $department = Department::find($request->branch_id);
        return view('admin.department.edit', compact('department_types', 'department'));
    }

    public function updateDepartment(Request $request)
    {
        $request->validate([
            'department_id' => 'required|numeric',
            'department_type_id' => 'required|numeric',
            'branch_code' => 'required||numeric',
            'branch_name' => 'required',
        ]);

        try {
            $branch = Department::find($request->department_id);
            $branch->department_type_id = $request->department_type_id;
            $branch->department_code = $request->branch_code;
            $branch->department_name = $request->branch_name;
            $branch->save();

            return redirect(route('admin.branch'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    // Class = Division
    public function division()
    {
        $divisions = Division::paginate(20);
        //  dd($classes);
        return view('admin.division.index', compact('divisions'));
    }

    public function addDivision(Request $request)
    {
        $departments = Department::get();
        return view('admin.division.add', compact('departments'));
    }

    public function saveDivision(Request $request)
    {
        $request->validate([
            'department_id' => 'required|numeric',
            'division_name' => 'required',
            'admission_year' => 'required||numeric',
        ]);

        try {
            $division = new Division();
            $division->department_id = $request->department_id;
            $division->division_name = $request->division_name;
            $division->admission_year = $request->admission_year;
            $division->save();

            return redirect(route('admin.division'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editDivision(Request $request)
    {
        $division = Division::find($request->division_id);
        $departments = Department::get();
        return view('admin.division.edit', compact('division', 'departments'));
    }

    public function updateDivision(Request $request)
    {
        $request->validate([
            'division_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'division_name' => 'required',
            'admission_year' => 'required||numeric',
        ]);

        try {
            $division = Division::find($request->division_id);
            $division->department_id = $request->department_id;
            $division->division_name = $request->division_name;
            $division->admission_year = $request->admission_year;
            $division->save();

            return redirect(route('admin.division'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    // Schedule Lacture = Time Table
    public function scheduleLecture()
    {
        $timetables = TimeTable::orderBy('id', 'DESC')->paginate(20);
        return view('admin.time-table.index', compact('timetables'));
    }

    public function addScheduleLecture(Request $request)
    {
        $divisions = Division::get();

        return view('admin.time-table.add', compact('divisions'));
    }

    public function saveScheduleLecture(Request $request, TimeTable $t)
    {
        $request->validate([
            'division_id' => 'required|numeric',
            'day_id' => 'required|numeric|between:1,7',
            'faculty_id' => 'required|numeric',
            'sem' => 'required|numeric|between:1,8',
            'subject_id' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
            'term_start_date' => 'required|date',
            'term_end_date' => 'required|date',
        ]);

        try {
            $lecture = new TimeTable();
            $lecture->division_id = $request->division_id;
            $lecture->weekday = $request->day_id;
            $lecture->faculty_id = $request->faculty_id;
            $lecture->sem = $request->sem;
            $lecture->subject_id = $request->subject_id;
            $lecture->setStartTimeAttribute($request->start_time);
            $lecture->setEndTimeAttribute($request->end_time);
            $lecture->term_start_date = $request->term_start_date;
            $lecture->term_end_date = $request->term_end_date;
            $lecture->save();

            return redirect(route('admin.time-table'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editScheduleLecture(Request $request)
    {
        $divisions = Division::get();
        $faculties = Faculty::get();
        $subjects = Subject::get();

        $timetable = TimeTable::find($request->timetable);

        return view('admin.time-table.edit', compact('divisions', 'faculties', 'subjects', 'timetable'));
    }

    public function updateScheduleLecture(Request $request)
    {
        $request->validate([
            'timetable' => 'required|numeric',
            'division_id' => 'required|numeric',
            'day_id' => 'required|numeric|between:1,7',
            'faculty_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'sem' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
            'term_start_date' => 'required|date',
            'term_end_date' => 'required|date',
        ]);

        try {
            $lecture = TimeTable::find($request->timetable);
            $lecture->division_id = $request->division_id;
            $lecture->weekday = $request->day_id;
            $lecture->faculty_id = $request->faculty_id;
            $lecture->sem = $request->sem;
            $lecture->subject_id = $request->subject_id;
            $lecture->setStartTimeAttribute($request->start_time);
            $lecture->setEndTimeAttribute($request->end_time);
            $lecture->term_start_date = $request->term_start_date;
            $lecture->term_end_date = $request->term_end_date;
            $lecture->save();

            return redirect(route('admin.time-table'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function viewScheduleLecture(Request $request, CalendarService $calendarService)
    {
        $request->validate([
            'division' => 'required|numeric',
            'sem' => 'required|numeric|between:1,8',
        ]);

        $weekDays     = TimeTable::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays);

        return view('admin.time-table.view', compact('weekDays', 'calendarData'));
    }

    // Lecture
    public function lecture()
    {
        $lectures = Lecture::orderBy('id', 'DESC')->paginate(20);
        $timetable = new TimeTable();
        return view('admin.lecture.index', compact('lectures', 'timetable'));
    }

    // public function addScheduleLecture(Request $request)
    // {
    //     $divisions = Division::get();
    //     $faculties = Faculty::get();
    //     $subjects = Subject::get();

    //     return view('admin.time-table.add', compact('divisions', 'faculties', 'subjects'));
    // }

    // public function saveScheduleLecture(Request $request, TimeTable $t)
    // {
    //     $request->validate([
    //         'division_id' => 'required|numeric',
    //         'day_id' => 'required|numeric|between:1,7',
    //         'faculty_id' => 'required|numeric',
    //         'sem' => 'required|numeric|between:1,8',
    //         'subject_id' => 'required|numeric',
    //         'start_time' => 'required',
    //         'end_time' => 'required',
    //         'term_start_date' => 'required|date',
    //         'term_end_date' => 'required|date',
    //     ]);

    //     try {
    //         $lecture = new TimeTable();
    //         $lecture->division_id = $request->division_id;
    //         $lecture->weekday = $request->day_id;
    //         $lecture->faculty_id = $request->faculty_id;
    //         $lecture->sem = $request->sem;
    //         $lecture->subject_id = $request->subject_id;
    //         $lecture->setStartTimeAttribute($request->start_time);
    //         $lecture->setEndTimeAttribute($request->end_time);
    //         $lecture->term_start_date = $request->term_start_date;
    //         $lecture->term_end_date = $request->term_end_date;
    //         $lecture->save();

    //         return redirect(route('admin.time-table'));
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // public function editScheduleLecture(Request $request)
    // {
    //     $divisions = Division::get();
    //     $faculties = Faculty::get();
    //     $subjects = Subject::get();

    //     $timetable = TimeTable::find($request->timetable);

    //     return view('admin.time-table.edit', compact('divisions', 'faculties', 'subjects', 'timetable'));
    // }

    // public function updateScheduleLecture(Request $request)
    // {
    //     $request->validate([
    //         'timetable' => 'required|numeric',
    //         'division_id' => 'required|numeric',
    //         'day_id' => 'required|numeric|between:1,7',
    //         'faculty_id' => 'required|numeric',
    //         'subject_id' => 'required|numeric',
    //         'sem' => 'required|numeric',
    //         'start_time' => 'required',
    //         'end_time' => 'required',
    //         'term_start_date' => 'required|date',
    //         'term_end_date' => 'required|date',
    //     ]);

    //     try {
    //         $lecture = TimeTable::find($request->timetable);
    //         $lecture->division_id = $request->division_id;
    //         $lecture->weekday = $request->day_id;
    //         $lecture->faculty_id = $request->faculty_id;
    //         $lecture->sem = $request->sem;
    //         $lecture->subject_id = $request->subject_id;
    //         $lecture->setStartTimeAttribute($request->start_time);
    //         $lecture->setEndTimeAttribute($request->end_time);
    //         $lecture->term_start_date = $request->term_start_date;
    //         $lecture->term_end_date = $request->term_end_date;
    //         $lecture->save();

    //         return redirect(route('admin.time-table'));
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // public function viewScheduleLecture(Request $request, CalendarService $calendarService)
    // {
    //     $request->validate([
    //         'division' => 'required|numeric',
    //         'sem' => 'required|numeric|between:1,8',
    //     ]);


    //     $weekDays     = TimeTable::WEEK_DAYS;
    //     $calendarData = $calendarService->generateCalendarData($weekDays);


    //     return view('admin.time-table.view', compact('weekDays', 'calendarData'));
    // }


    public function attendance()
    {
        $faculty_id = Session::get('faculty');
        $faculty = Faculty::select('first_name', 'last_name', 'middle_name', 'department_id')->find($faculty_id);
        $divisions = Division::where('department_id', '=', $faculty->department_id)->get();
        $subjects = Subject::where('department_id', '=', $faculty->department_id)->get();

        return view('admin.attendance.index', compact('faculty', 'divisions', 'subjects'));
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
            return redirect()->route('admin.attendance')->with('error', 'No Lectures Found !');
        }

        return Excel::download(new AttendanceExport($division_id, $subject_id), 'attendance.xlsx');
    }

    // public function attendance()
    // {
    //     dd("HI");
    // }


    // public function attendanceView(Request $request)
    // {
    //     $request->validate([
    //         'division' => 'required|numeric',
    //         'lecture' => 'required|numeric|between:1,8',
    //     ]);

    //     $students = Student::where('division_id', '=', $request->division)->get();
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
    //             ->where('lecture_id', '=', $request->lecture)
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

    //     dd($attendeeData);
    //     return view('admin.attendance.view', compact('attendeeData', 'lectureData'));
    // }
}
