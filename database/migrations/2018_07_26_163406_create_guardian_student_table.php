<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardianStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardian_student', function (Blueprint $table) {
            $table->integer('guardian_id')->unsigned();
			$table->foreign('guardian_id')->references('id')->on('guardians');            
			$table->integer('student_id')->unsigned();
			$table->foreign('student_id')->references('id')->on('students');
			$table->string('relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardian_student');
    }
}
