<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeTable extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'weekday',
        'division_id',
        'faculty_id',
        'subject_id',
        'sem',

        'start_time',
        'end_time',

        'term_start_date',
        'term_end_date',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const WEEK_DAYS = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
    ];
    // '6' => 'Saturday',
    // '7' => 'Sunday',

    public function division()
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }


    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function lecture()
    {
        return $this->hasMany(Lecture::class, 'id', 'time_table_id');
    }


    public static function getFaculties($time_table_id, $is_lab)
    {
        if ($is_lab) {
            $faculties = FacultyLecturer::where('time_table_id', $time_table_id)
                ->join('faculties', 'faculties.id', '=', 'faculty_lecturers.faculty_id')
                ->select('faculty_lecturers.lab_name', 'faculties.short_name')
                ->get();

            return $faculties;
        }
        $faculties = FacultyLecturer::where('time_table_id', $time_table_id)
            ->join('faculties', 'faculties.id', '=', 'faculty_lecturers.faculty_id')
            ->select('faculties.short_name')
            ->first();
        return $faculties;
    }

    public static function getFullFacultyDetail($time_table_id, $is_lab)
    {
        if ($is_lab) {
            $faculties = FacultyLecturer::where('time_table_id', $time_table_id)
                ->join('faculties', 'faculties.id', '=', 'faculty_lecturers.faculty_id')
                ->select('faculty_lecturers.lab_name', 'faculties.short_name')
                ->get();

            return $faculties;
        }

        // return $faculties = FacultyLecturer::where('time_table_id', '=', $time_table_id)->with('faculty')->first();
        $faculties = FacultyLecturer::where('time_table_id', $time_table_id)
            ->join('faculties', 'faculties.id', '=', 'faculty_lecturers.faculty_id')
            ->select('faculties.short_name', 'faculties.first_name', 'faculties.last_name', 'faculties.middle_name')
            ->first();

        return $faculties;
    }

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        // dd(Carbon::now('+5:30 UTC'));
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(
            config('panel.lesson_time_format'),
            $value
        )->format('H:i:s') : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setEndTimeAttribute($value)
    {

        $this->attributes['end_time'] = $value ? Carbon::createFromFormat(
            config('panel.lesson_time_format'),
            $value
        )->format('H:i:s') : null;
    }



    public static function isTimeAvailable($weekday, $startTime, $endTime, $class, $teacher, $lesson)
    {
        $lessons = self::where('weekday', $weekday)
            ->when($lesson, function ($query) use ($lesson) {
                $query->where('id', '!=', $lesson);
            })
            ->where(function ($query) use ($class, $teacher) {
                $query->where('division_id', $class)
                    ->orWhere('faculty_id', $teacher);
            })
            ->where([
                ['start_time', '<', $endTime],
                ['end_time', '>', $startTime],
            ])
            ->count();

        return !$lessons;
    }

    public function scopeCalendarByRoleOrClassId($query)
    {
        // return $query->when(!request()->input('lecture_id'), function ($query) {
        //     $query->when(auth()->user()->is_teacher, function ($query) {
        //         $query->where('faculty_id', auth()->user()->id);
        //     })
        //         ->when(auth()->user()->is_student, function ($query) {
        //             $query->where('division_id', auth()->user()->division_id ?? '0');
        //         });
        // })
        //     ->when(request()->input('lecture_id'), function ($query) {
        //         $query->where('division_id', request()->lecture_id);
        //     });

        return $query->when(!request()->input('division'), function ($query) {
        })->when(request()->input('division'), function ($query) {
            $query->where('division_id', request()->division);
        })->when(request()->input('sem'), function ($query) {
            $query->where('sem', request()->sem);
        });
    }
}
