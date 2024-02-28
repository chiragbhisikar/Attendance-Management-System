<?php

use Illuminate\Support\Facades\Route;
// ==================Auth==================
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FacultyAuthController;
use App\Http\Controllers\StudentAuthController;


// ==================System Controller==================
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StudentController;

// Main Page
Route::get('/', [FrontController::class, 'index']);

// =====================Admin Side======================

Route::group(['prefix' => 'admin', 'middleware' => ['AdminAlreadyLoggedIn']], function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'loginCheck'])->name('admin.loginCheck');
});

Route::group(['prefix' => 'admin', 'middleware' => ['AdminAuthCheck']], function () {
    Route::group(['prefix' => 'ajax'], function () {
        // route::post('/get-data', [FilterController::class, 'getData'])->name('admin.get-data');
        route::post('/get-faculty', [FilterController::class, 'getFaculty'])->name('admin.get-faculty');
        route::post('/get-subject', [FilterController::class, 'getSubject'])->name('admin.get-subject');
    });

    route::get('/', [AdminAuthController::class, 'index'])->name('admin.dashboard');


    // faculty
    Route::group(['prefix' => 'faculty'], function () {
        route::get('/', [AdminController::class, 'faculty'])->name('admin.faculty');

        // Add
        route::get('/add-faculty', [AdminController::class, 'addFaculty'])->name('admin.add-faculty');
        route::post('/save-faculty', [AdminController::class, 'saveFaculty'])->name('admin.save-faculty');

        // Edit
        route::get('/edit-faculty', [AdminController::class, 'editFaculty'])->name('admin.edit-faculty');
        route::post('/update-faculty', [AdminController::class, 'updateFaculty'])->name('admin.update-faculty');

        // forget-password
        route::get('/forget-password-faculty', [AdminController::class, 'forgetPasswordFaculty'])->name('admin.forget-password-faculty');
        route::post('/update-password-faculty', [AdminController::class, 'updatePasswordFaculty'])->name('admin.update-password-faculty');

        // Filter Faculty
        route::get('/filter-faculty', [AdminController::class, 'filterFaculty'])->name('admin.filter-faculty');
    });


    // Attendance 
    Route::group(['prefix' => 'attendance'], function () {
        // Route::get('/', [AdminController::class, 'attendance'])->name('admin.attendance');
        // Route::get('/', [AdminController::class, 'attendance'])->name('admin.attendance');
        // Route::post('/export-attendance', [AdminController::class, 'exportAttendance'])->name('admin.export-attendance');

        Route::get('/', [AdminController::class, 'attendance'])->name('admin.attendance');
        Route::post('/export-attendance', [AdminController::class, 'exportAttendance'])->name('admin.export-attendance');


        Route::get('/view', [AdminController::class, 'attendanceView'])->name('admin.view-attendance');
    });


    // Attendance 
    //   Route::group(['prefix' => 'attendance'], function () {
    //     route::get('/', [AdminController::class, 'attendance'])->name('admin.attendance');
    //     route::get('/view', [AdminController::class, 'attendanceView'])->name('admin.view-attendance');

    //     // Add
    //     // route::get('/add-attendance', [AdminController::class, 'addAttendance'])->name('admin.add-attendance');
    //     // route::post('/save-attendance', [AdminController::class, 'saveAttendance'])->name('admin.save-attendance');

    //     // // Edit
    //     // route::get('/edit-attendance', [AdminController::class, 'editAttendance'])->name('admin.edit-attendance');
    //     // route::post('/update-attendance', [AdminController::class, 'updateAttendance'])->name('admin.update-attendance');
    // });

    // subject
    Route::group(['prefix' => 'subject'], function () {
        route::get('/', [AdminController::class, 'subject'])->name('admin.subject');

        // Add
        route::get('/add-subject', [AdminController::class, 'addSubject'])->name('admin.add-subject');
        route::post('/save-subject', [AdminController::class, 'saveSubject'])->name('admin.save-subject');

        // Edit
        route::get('/edit-subject', [AdminController::class, 'editSubject'])->name('admin.edit-subject');
        route::post('/update-subject', [AdminController::class, 'updateSubject'])->name('admin.update-subject');

        // Filter Faculty
        route::get('/filter-subject', [AdminController::class, 'filterSubject'])->name('admin.filter-subject');
    });



    // branch = Department
    Route::group(['prefix' => 'branch'], function () {
        route::get('/', [AdminController::class, 'department'])->name('admin.branch');

        // Add
        route::get('/add-branch', [AdminController::class, 'addDepartment'])->name('admin.add-branch');
        route::post('/save-branch', [AdminController::class, 'saveDepartment'])->name('admin.save-branch');

        // Edit
        route::get('/edit-branch', [AdminController::class, 'editDepartment'])->name('admin.edit-branch');
        route::post('/update-branch', [AdminController::class, 'updateDepartment'])->name('admin.update-branch');
    });



    // Class = Division
    Route::group(['prefix' => 'division'], function () {
        route::get('/', [AdminController::class, 'division'])->name('admin.division');

        // Add
        route::get('/add-division', [AdminController::class, 'addDivision'])->name('admin.add-division');
        route::post('/save-division', [AdminController::class, 'saveDivision'])->name('admin.save-division');

        // Edit
        route::get('/edit-division', [AdminController::class, 'editDivision'])->name('admin.edit-division');
        route::post('/update-division', [AdminController::class, 'updateDivision'])->name('admin.update-division');
    });


    // Time Table => Set Lacture Timing
    Route::group(['prefix' => 'time-table'], function () {
        route::get('/', [AdminController::class, 'scheduleLecture'])->name('admin.time-table');

        // Add
        route::get('/add-time-table', [AdminController::class, 'addScheduleLecture'])->name('admin.add-time-table');
        route::post('/save-time-table', [AdminController::class, 'saveScheduleLecture'])->name('admin.save-time-table');

        // Edit
        route::get('/edit-time-table', [AdminController::class, 'editScheduleLecture'])->name('admin.edit-time-table');
        route::post('/update-time-table', [AdminController::class, 'updateScheduleLecture'])->name('admin.update-time-table');

        // View
        route::get('/view-time-table', [AdminController::class, 'viewScheduleLecture'])->name('admin.view-time-table');

        // // Filter Faculty
        // route::get('/filter-faculty', [AdminController::class, 'filterTimeTable'])->name('admin.time-table');
    });


    // Lecture 
    Route::group(['prefix' => 'lecture'], function () {
        route::get('/', [AdminController::class, 'lecture'])->name('admin.lecture');

        // // Add
        // route::get('/add-lecture', [AdminController::class, 'addLecture'])->name('admin.add-lecture');
        // route::post('/save-lecture', [AdminController::class, 'saveLecture'])->name('admin.save-lecture');

        // // Edit
        // route::get('/edit-lecture', [AdminController::class, 'editLecture'])->name('admin.edit-lecture');
        // route::post('/update-lecture', [AdminController::class, 'updateLecture'])->name('admin.update-lecture');
    });





    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


// =====================Faculty Side======================

Route::group(['prefix' => 'faculty', 'middleware' => ['FacultyAlreadyLoggedIn']], function () {
    Route::get('/login', [FacultyAuthController::class, 'login'])->name('faculty.login');
    Route::post('/login', [FacultyAuthController::class, 'loginCheck'])->name('faculty.loginCheck');
});


Route::group(['prefix' => 'faculty', 'middleware' => ['FacultyAuthCheck']], function () {
    Route::get('/', [FacultyController::class, 'index'])->name('faculty.dashboard');

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/', [FacultyController::class, 'attendance'])->name('faculty.attendance');
        Route::post('/export-attendance', [FacultyController::class, 'exportAttendance'])->name('faculty.export-attendance');
    });


    Route::group(['prefix' => 'lecture'], function () {
        Route::get('/rescheduled-lecture', [FacultyController::class, 'rescheduleLecture'])->name('faculty.rescheduled-lecture');
        Route::post('/save-rescheduled-lecture', [FacultyController::class, 'saveRescheduleLecture'])->name('faculty.save-reschedule-lecture');
        Route::post('/export-attendance', [FacultyController::class, 'exportAttendance'])->name('faculty.export-attendance');

        // Take Attendance
        Route::get('/take-attendance', [FacultyController::class, 'takeAttendance'])->name('faculty.take-attendance');
        Route::post('/save-take-attendance', [FacultyController::class, 'saveTakeAttendance'])->name('faculty.save-take-attendance');

        Route::get('/control-lecture', [FacultyController::class, 'controlLecture'])->name('faculty.control-lecture');
    });

    Route::get('/logout', [FacultyAuthController::class, 'logout'])->name('faculty.logout');
});




// Route::group(['prefix' => 'faculty', 'middleware' => ['AlreadyLoggedIn']], function () {
//     // Route::get('/register', [FacultyController::class, 'login'])->name('faculty.login');
//     // Route::post('/register-student', [FacultyController::class, 'loginCheck'])->name('faculty.loginCheck');

//     Route::get('/login', [FacultyController::class, 'login'])->name('faculty.login');
//     Route::post('/login', [FacultyController::class, 'loginCheck'])->name('faculty.loginCheck');
// });

// =====================Student Side======================
Route::group(['prefix' => 'student', 'middleware' => ['StudentAlreadyLoggedIn']], function () {
    // Route::get('/register', [StudentController::class, 'login'])->name('student.login');
    // Route::post('/register-student', [StudentController::class, 'loginCheck'])->name('student.loginCheck');

    Route::get('/login', [StudentAuthController::class, 'login'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'loginCheck'])->name('student.loginCheck');
});

Route::group(['prefix' => 'student', 'middleware' => ['StudentAuthCheck']], function () {
    Route::get('/', [StudentController::class, 'index'])->name('student.dashboard');
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/give-attendance', [StudentController::class, 'giveAttendance'])->name('student.give-attendance');
        Route::post('/save-attendance', [StudentController::class, 'saveAttendance'])->name('student.save-attendance');
    });

    Route::group(['prefix' => 'time-table'], function () {
        Route::get('/', [StudentController::class, 'viewTimeTable'])->name('student.time-table');
        Route::post('/save-attendance', [StudentController::class, 'saveAttendance'])->name('student.save-attendance');
    });

    Route::get('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
});


/*
Route::group(['prefix' => 'student', 'middleware' => ['AuthCheck']], function () {
    route::get('/', [FacultyController::class, 'index'])->name('faculty.dashboard');
    Route::get('/logout', [FacultyController::class, 'logout'])->name('faculty.logout');
});



Route::group(['prefix' => 'student', 'middleware' => ['AuthCheck']], function () {
    route::get('/', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/logout', [StudentController::class, 'logout'])->name('student.logout');
});
*/

/*
       Route::group(['prefix' => 'lecture'], function () {
        route::get('/', [AdminController::class, 'scheduleLecture'])->name('admin.schedule-lecture');

        // Add
        route::get('/add-schedule-lecture', [AdminController::class, 'addScheduleLecture'])->name('admin.add-schedule-lecture');
        route::post('/save-schedule-lecture', [AdminController::class, 'saveScheduleLecture'])->name('admin.save-schedule-lecture');

        // Edit
        route::get('/edit-schedule-lecture', [AdminController::class, 'editScheduleLecture'])->name('admin.edit-schedule-lecture');
        route::post('/update-schedule-lecture', [AdminController::class, 'updateScheduleLecture'])->name('admin.update-schedule-lecture');
    }); 
     */


Route::get('/test', [FrontController::class, 'test']);
Route::post('/import-timetable', [FrontController::class, 'importTimetable'])->name('import-timetable');
