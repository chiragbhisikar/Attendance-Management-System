<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('time_table_id');
            $table->foreign('time_table_id')->references('id')->on('time_tables');

            $table->foreignId('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties');

            $table->time('start_time');
            $table->time('end_time');
            $table->string('holiday_reason')->nullable();
            $table->date('date_of_lecture');
            $table->string('slug', 50)->unique();
            
            
            $table->integer('otp');
            $table->timestamps();
            
            $table->boolean('is_open')->default(0);
        });

        DB::statement('ALTER TABLE lectures ADD CONSTRAINT check_end_time_greater_than_start_time_for_lecture CHECK (end_time > start_time);');

        DB::table('lectures')->insert(
            array(
                [
                    'time_table_id' => 1,
                    'start_time' => '12:30',
                    'end_time' => '02:30',
                    'date_of_lecture' => '2023-11-30',
                    'slug' => 'abcdefghijklmnopqrstuvwxyz',
                    'otp' => 123456,
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
        Schema::dropIfExists('lectures');
    }
}
