<?php

namespace App\Imports;

use App\Models\Faculty;
use App\Models\FacultyLecturer;
use App\Models\Subject;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimetableImport implements ToModel, WithHeadingRow
{
    private $subjects, $faculties, $division, $sem, $term_start_date, $term_end_date;

    public function __construct($division, $sem, $term_start_date, $term_end_date)
    {
        $this->subjects = Subject::select('id', 'short_name')->get();
        $this->faculties = Faculty::select('id', 'short_name')->get();
        $this->sem = $sem;
        $this->$division = $division;
        $this->term_start_date = $term_start_date;
        $this->term_end_date = $term_end_date;
    }

    public function model(array $row)
    {
        if ($row['lecturelab'] == 'Lecture') {
            $startTime = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_time']))->format('H:i');
            $endTime = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_time']))->format('H:i');
            $subject = $this->subjects->where('short_name', '=', $row['subject'])->first();
            $faculty = $this->faculties->where('short_name', '=', $row['faculty'])->first();
            $weekday = getDayByName($row['day']);

            try {
                $timetable = new Timetable();
                $timetable->weekday = $weekday;
                $timetable->division_id = 1;
                $timetable->subject_id = $subject->id;
                $timetable->sem = 4;
                $timetable->is_lab = 0;
                $timetable->start_time = $startTime;
                $timetable->end_time = $endTime;
                $timetable->term_start_date = $this->term_start_date;
                $timetable->term_end_date = $this->term_end_date;;
                $timetable->save();


                return new FacultyLecturer([
                    'time_table_id' => $timetable->id,
                    'faculty_id' => $faculty->id,
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }
        } elseif ($row['lecturelab'] == 'Lab') {
            $type = 'Lab';
            $startTime = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_time']))->format('H:i');
            $endTime = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_time']))->format('H:i');
            $subject = $this->subjects->where('short_name', '=', $row['subject'])->first();
            $faculty = $this->faculties->where('short_name', '=', $row['faculty'])->first()->id ?? 21;
            $weekday = getDayByName($row['day']);


            // Division Pending
            $isExist = Timetable::where('start_time', '=', $startTime)->where('end_time', '=', $endTime)->where('weekday', '=', $weekday)
                ->where('division_id', '=', 1)->where('subject_id', '=', $subject->id)->where('term_start_date', '=', $this->term_start_date)->where('term_end_date', '=', $this->term_end_date)->first();

            try {
                if ($isExist == null) {
                    $timetable = new Timetable();
                    $timetable->weekday = $weekday;
                    // Division Pending
                    $timetable->division_id = 1;
                    $timetable->subject_id = $subject->id;
                    $timetable->sem = 4;
                    $timetable->is_lab = 1;
                    $timetable->start_time = $startTime;
                    $timetable->end_time = $endTime;
                    $timetable->term_start_date = $this->term_start_date;
                    $timetable->term_end_date = $this->term_end_date;;
                    $timetable->save();

                    // dd($faculty->id);
                    return new FacultyLecturer([
                        'time_table_id' => $timetable->id,
                        'lab_name' => $row['lab_name'],
                        'faculty_id' => $faculty,
                    ]);
                } else {
                    return new FacultyLecturer([
                        'time_table_id' => $isExist->id,
                        'lab_name' => $row['lab_name'],
                        'faculty_id' => $faculty,
                    ]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    // public function rules(): array
    // {
    //     return [
    //         '0' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
    //         '1' => 'required|string',
    //         '2' => 'required|string',
    //         '3' => 'required|in:Lecture,Lab',
    //         '4' => Rule::requiredIf(fn () => request()->input('3') === 'Lab') . '|string', // Lab name is required if the entry is a lab
    //         '5' => 'required|date_format:H:i',
    //         '6' => 'required|date_format:H:i|after:5:00', // Assuming classes should start after 5:00 AM
    //     ];
    // }

    // public function customValidationMessages()
    // {
    //     return [
    //         '4.required' => 'The Lab name field is required when lecturelab is "Lab".',
    //         '6.after' => 'The end time must be after 5:00 AM.',
    //         '8.after' => 'The term end date must be after the term start date.',
    //     ];
    // }
}
