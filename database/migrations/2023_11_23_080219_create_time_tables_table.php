<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTimeTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();

            $table->foreignId('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');

            // $table->foreignId('faculty_id');
            // $table->foreign('faculty_id')->references('id')->on('faculties');

            $table->foreignId('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->integer('sem');

            $table->smallInteger('weekday')->comment('1 => Monday,2 => Tuesday,3 => Wednesday,4 => Thursday,5 => Friday,6 => Saturday,7 => Sunday');

            $table->boolean('is_lab')->default(0)->comment('0 => Lecture,1 => Lab');

            $table->time('start_time');
            $table->time('end_time');

            $table->date('term_start_date');
            $table->date('term_end_date');

            $table->timestamps();
        });

        DB::statement('ALTER TABLE time_tables ADD CONSTRAINT CHK_Day CHECK (weekday >= 1 AND weekday <= 7);');
        DB::statement('ALTER TABLE time_tables ADD CONSTRAINT check_end_time_greater_than_start_time CHECK (end_time > start_time);');
        DB::statement('ALTER TABLE time_tables ADD CONSTRAINT CHK_Sem CHECK (sem >= 1 AND sem <= 8);');

        DB::table('time_tables')->insert(
            array(
                [
                    'division_id' => 1,
                    'subject_id' => 1,
                    'sem' => 3,
                    'weekday' => 1,
                    'start_time' => '10:30:00',
                    'end_time' => '11:30:00',
                    'term_start_date' => '2023-08-14',
                    'term_end_date' => '2023-12-30',
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_tables');
    }
}
