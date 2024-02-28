<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('division_name', 1);

            $table->foreignId('department_id');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->integer('admission_year');
            $table->integer('current_sem')->default(1);
            $table->unique(['division_name',  'department_id', 'admission_year']);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE divisions ADD CONSTRAINT chk_division_sem CHECK (current_sem >= 1 AND current_sem <= 8);');

        DB::table('divisions')->insert(
            array(
                [
                    'division_name' => 'A',
                    'department_id' => 1,
                    'admission_year' => 2022,
                    'current_sem' => 1,
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
        Schema::dropIfExists('divisions');
    }
}
