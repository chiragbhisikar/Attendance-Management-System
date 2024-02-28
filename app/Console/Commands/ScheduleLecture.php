<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Lecture;
use App\Models\TimeTable;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ScheduleLecture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:schedulelecture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Is Schedule Lecture On Time Table Basis!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $date_of_lecture = Carbon::parse($now)->format('Y-m-d');
        $weekday = Carbon::parse($now)->format('N');

        $todaysLectures = TimeTable::where('term_start_date', '<=', $date_of_lecture)->where('term_end_date', '>=', $date_of_lecture)->where('weekday', '=', $weekday)->get();

        foreach ($todaysLectures as $todaysLecture) {
            $lecture = new Lecture();
            $lecture->time_table_id = $todaysLecture->id;
            $lecture->start_time = $todaysLecture->start_time;
            $lecture->end_time = $todaysLecture->end_time;
            $lecture->date_of_lecture = $date_of_lecture;
            $lecture->slug = Str::random(50);
            $lecture->otp = rand(111111, 999999);
            $lecture->save();
        }
    }
}
