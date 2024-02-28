<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('enrollment_no', 15)->nullable();
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('middle_name', 25);

            $table->string('email')->unique();
            $table->string('phone_number')->unique();

            $table->foreignId('department_id');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->year('admission_year');
            $table->integer('student_type')->comment('1 => Regular,2 => D2D');

            $table->foreignId('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');

            $table->integer('temporary_id')->nullable();
            $table->string('password');
            $table->timestamps();
        });

        // DB::table('students')->insert(
        //     array(
        //         [
        //             'first_name' => 'Chirag',
        //             'last_name' => 'Bhisikar',
        //             'middle_name' => 'Rajeshbhai',
        //             'enrollment_no' => 200202101001,
        //             'email' => 'chiragbhisikar2208@gmail.com',
        //             'phone_number' => 9016625319,
        //             'admission_year' => 2023,
        //             'student_type' => 1,
        //             'division_id' => 1,
        //             'department_id' => 1,
        //             'password' => Hash::make('Chirag#2208')
        //         ],
        //         [
        //             'first_name' => 'Aditya',
        //             'last_name' => 'Talaviya',
        //             'middle_name' => 'Manojbhai',
        //             'enrollment_no' => 200202101002,
        //             'email' => 'adityatalaviya@gmail.com',
        //             'phone_number' => 9737399901,
        //             'admission_year' => 2023,
        //             'student_type' => 2,
        //             'division_id' => 1,
        //             'department_id' => 1,
        //             'password' => Hash::make('Chirag#2208')
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
        Schema::dropIfExists('students');
    }
}
