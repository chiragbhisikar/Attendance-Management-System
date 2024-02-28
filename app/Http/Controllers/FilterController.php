<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Department;
use App\Models\DepartmentType;
use App\Models\Division;
use App\Models\TimeTable;
use Illuminate\Http\Client\Response;

class FilterController extends Controller
{
    public function getFaculty(Request $request)
    {
        $request->validate([
            'division' => 'required|numeric',
        ]);

        $division = Division::find($request->division);
        $faculties = Faculty::where('department_id', '=', $division->department_id)->with('department')->get();
        // $subjects = Subject::where('department_id', '=', $division->department_id)->with('department')->get();
        // , 'subjects' => $subjects
        return response(['status' => 200, 'error' => false, 'faculties' => $faculties]);
    }


    public function getSubject(Request $request)
    {
        $request->validate([
            'division' => 'required|numeric',
            'sem' => 'required|numeric',
        ]);

        $division = Division::find($request->division);
        $subjects = Subject::where('department_id', '=', $division->department_id)->where('sem', '=', $request->sem)->with('department')->get();

        return response(['status' => 200, 'error' => false, 'subjects' => $subjects]);
    }
}
