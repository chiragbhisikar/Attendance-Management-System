<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('students');

            $table->foreignId('lecture_id');
            $table->foreign('lecture_id')->references('id')->on('lectures');

            $table->float('latitude');
            $table->float('longitude');

            $table->timestamp('created_at')->useCurrent();
        });

        // DB::table('attendances')->insert(
        //     array(
        //         [
        //             'student_id' => 1,
        //             'lecture_id' => 1,
        //             'latitude' => 72.890987,
        //             'longitude' => 75.00000,
        //         ],
        //     )
        // );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
