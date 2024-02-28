<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_table_id');
            $table->foreign('time_table_id')->references('id')->on('time_tables');

            $table->foreignId('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties');

            $table->string('lab_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_lecturers');
    }
}
