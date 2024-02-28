<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->integer('code');
            $table->integer('sem');
            $table->foreignId('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->timestamps();
        });


        DB::table('subjects')->insert(
            array(
                [
                    'name' => 'Data Structures',
                    'short_name' => 'DS',
                    'code' => 3130702,
                    'sem' => 3,
                    'department_id' => 1,
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
        Schema::dropIfExists('subjects');
    }
}
