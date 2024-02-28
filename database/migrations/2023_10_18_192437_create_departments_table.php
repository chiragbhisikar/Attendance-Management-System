<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_type_id');
            $table->integer('department_code')->unique();
            $table->foreign('department_type_id')->references('id')->on('department_types');
            $table->string('department_name', 50)->unique();
        });

        DB::table('departments')->insert(
            array(
                [
                    'department_type_id' => 1,
                    'department_code' => 16,
                    'department_name' => 'Information Technology',
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
        Schema::dropIfExists('departments');
    }
}
