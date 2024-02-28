<?php

use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\TimeTable;
use Carbon\Carbon;
// function UploadImage($path, $file)
// {
//     $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//     $imageName = 'profile' . rand(1000, 99999) . time() . '.' . $file->getClientOriginalExtension();
//     $file->move(base_path() . '/public' . $path, $imageName);
//     return $path . '/' . $imageName;
// }

// function display_date($date)
// {
//     return date('d-m-Y', strtotime($date));
// }

// function UploadToStorage($path, $file)
// {
//     $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//     $imageName = $filename . rand(1000, 99999) . time() . '.' . $file->getClientOriginalExtension();
//     $file->move(base_path() . '/storage/app/public/' . $path, $imageName);

//     $uploaded_img_path = 'storage/' . $path . '/' . $imageName;

//     $path1 = base_path() . '/storage/app/public/' . $path . '/' . $imageName;

//     return $uploaded_img_path;
// }

function getDay($numOfDay)
{
    if ($numOfDay > 7) {
        return 'Something worng';
    }
    $days = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ];

    return $days[$numOfDay];
}


function getDayByName($dayName)
{
    if ($dayName == 'Monday') {
        return 1;
    }
    if ($dayName == 'Tuesday') {
        return 2;
    }
    if ($dayName == 'Wednesday') {
        return 3;
    }
    if ($dayName == 'Thursday') {
        return 4;
    }
    if ($dayName == 'Friday') {
        return 5;
    }
    if ($dayName == 'Saturday') {
        return 6;
    }
    if ($dayName == 'Sunday') {
        return 7;
    }

    return 1;
}

function getDayList()
{
    $days = [
        [
            'id' => 1,
            'name' => 'Monday'
        ],
        [
            'id' => 2,
            'name' => 'Tuesday'
        ],
        [
            'id' => 3,
            'name' => 'Wednesday'
        ],
        [
            'id' => 4,
            'name' => 'Thursday'
        ],
        [
            'id' => 5,
            'name' => 'Friday'
        ],
        [
            'id' => 6,
            'name' => 'Saturday'
        ],
        [
            'id' => 7,
            'name' => 'Sunday'
        ],
    ];

    return $days;
}


function getTimeDifference($start_time, $end_time, $difference)
{
    $to = Carbon::createFromFormat('H:s', $start_time);
    $from = Carbon::createFromFormat('H:s', $end_time);

    $hour = $to->diff($from)->format('%H');
    $minute = $to->diff($from)->format('%S');

    $diffInMinutes =  (($hour * 60) + $minute) / $difference;

    return $diffInMinutes;
}


function getFacultyCount($time_table_id)
{
    // $facultyCount = TimeTable::where('time_table')
    // return $diffInMinutes;
}
function getTimeTable($time_table_id)
{
    $timetable = TimeTable::find($time_table_id);
    return $timetable;
}

function checkAttended($lecture_id, $student_id)
{
    $attended = Attendance::where('student_id', '=', $student_id)->where('lecture_id', '=', $lecture_id)->first();
    if ($attended) {
        return true;
    }

    return false;
}
