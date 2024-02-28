<?php

namespace App\Services;

use App\Models\TimeTable;
use Carbon\Carbon;

class CalendarService
{
    public function generateCalendarData($weekDays)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons   = TimeTable::with('division')
            ->calendarByRoleOrClassId()
            ->get();

        foreach ($timeRange as $time) {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day) {
                $lesson = $lessons->where('weekday', $index)->where('start_time', $time['start'])->first();
                
                if ($lesson) {
                    $faculty = TimeTable::getFaculties($lesson->id, $lesson->is_lab);

                    array_push($calendarData[$timeText], [
                        'subject' => $lesson->subject,
                        'division' => $lesson->division,
                        'faculty'  => $faculty,
                        'rowspan'  => getTimeDifference($time['start'], $lesson->end_time, 30) ?? "",
                        'is_lab' => $lesson->is_lab,
                    ]);
                    
                    
                } else if (!$lessons->where('weekday', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count()) {
                    array_push($calendarData[$timeText], 1);
                } else {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }
        
        return $calendarData;
    }
}
