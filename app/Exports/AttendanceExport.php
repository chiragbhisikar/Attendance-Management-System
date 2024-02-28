<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Lecture;
use App\Models\TimeTable;
use App\Models\Attendance;
use App\Models\Division;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;
use PDO;

class AttendanceExport implements FromCollection, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $division_id, $subject_id;

    public function __construct($division_id, $subject_id)
    {
        $this->division_id = $division_id;
        $this->subject_id = $subject_id;
    }

    public function collection()
    {
        try {
            // Setting Where division_id & subject_id For Getting Attendance
            $lectures = Lecture::whereHas('timeTable', function ($query) {
                $query->where('division_id', $this->division_id)
                    ->where('subject_id', $this->subject_id);
            })->select('id', 'date_of_lecture')->get();

            // if (count($lectures) == 0) {
            //     return redirect()->route('faculty.attendance')->with('error', 'No Lectures Found !');
            // }

            $attendanceData = Attendance::with(['lecture', 'student'])
                ->select('student_id', 'lecture_id', 'created_at')
                ->get();

            $division = Division::find($this->division_id);
            $subject = Subject::find($this->subject_id);
            $timetable = TimeTable::where('division_id', $this->division_id)->where('subject_id', $this->subject_id)->where('is_lab', '=', 0)->first();

            // $timetable_no_lab = TimeTable::where('division_id', $this->division_id)
            //     ->where('subject_id', $this->subject_id)
            //     ->first();
            $faculty = TimeTable::getFullFacultyDetail($timetable->id, $timetable->is_lab);


            $exportData = new Collection();
            $headerRow  =
                [
                    '',
                    '',
                    'B.E. Branch -- ' . $division->department->department_name  . "\n" . ' Division -- ' . ' ' . $division->division_name . ' - ' . $division->admission_year  . ' Term Start Date -- ' . $timetable->term_start_date . ' Term End Date -- ' . $timetable->term_end_date . "\n" . ' Faculty Name: ' . $faculty->first_name . ' ' . $faculty->middle_name . ' ' . $faculty->last_name . "\n" . ' Subject code: ' . $subject->code . ' Subject Name: ' . $subject->name,
                ];
            $exportData->push($headerRow);

            $headerRow = ['Enrollment No', 'Name'];
            // Add date headers -> Setting Dates As A Row In Excel File
            foreach ($lectures as $lecture) {
                $headerRow[] = $lecture->date_of_lecture;
            }
            $headerRow[] = 'Total Lecture';
            $headerRow[] = 'Attended Lecture';
            $headerRow[] = 'Attended Percentage';
            $exportData->push($headerRow);

            // Create Student rows
            $students = Student::where('division_id', $this->division_id)->select('id', 'enrollment_no', 'first_name', 'middle_name', 'last_name')->orderBy('enrollment_no', 'ASC')->get();

            foreach ($students as $student) {
                $name = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                $rowData = [$student->enrollment_no, $name];

                $count_present = 0;
                $total_lecture = 0;
                foreach ($lectures as $lecture) {
                    $attendance = $attendanceData
                        ->where('student_id', $student->id)
                        ->where('lecture_id', '=', $lecture->id)
                        ->first();

                    $rowData[] = $attendance ? 'P' : 'A';

                    if ($attendance) {
                        $count_present = $count_present + 1;
                    }
                    $total_lecture = $total_lecture + 1;
                }

                $rowData[] =  (string)$total_lecture;
                $rowData[] = (string)$count_present;
                if ($total_lecture == 0) {
                    $rowData[] = '0%';
                } else {
                    $rowData[] = (string)(($count_present * 100) / $total_lecture) . '%';
                }
                $exportData->push($rowData);
            }

            return $exportData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Access the current active sheet
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('C1:J1');

                $sheet->getStyle('C1:J1')->applyFromArray([
                    'font' => [
                        'name' => 'Calibri',
                        'size' => 11, // Set your desired font size
                        'text-align' => 'center',
                    ],
                ]);

                // $sheet->setRowHeight(1, 30); // Set your desired row height
                $sheet->getRowDimension(1)->setRowHeight(75);
                $sheet->getStyle('C1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
