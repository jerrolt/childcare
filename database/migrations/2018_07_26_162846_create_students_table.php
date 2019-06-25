<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
			$table->string('status',20)->default('pending'); //pending, active, disabled
			
			$table->integer('primary_guardian_id')->unsigned();
			$table->integer('facility_id')->unsigned();
            $table->integer('classroom_id')->unsigned();
            
            $table->string('firstname');
            $table->string('lastname');
            $table->string('mi')->nullable();
            $table->string('suffix')->nullable();
            
            $table->string('image')->nullable();
            
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('special_needs')->nullable();
            $table->string('special_code')->nullable();
            $table->string('allergies')->nullable();
            
            $table->timestamps();
            
            $table->foreign('primary_guardian_id')->references('id')->on('guardians');
            $table->foreign('facility_id')->references('id')->on('facilities');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });
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
