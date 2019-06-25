<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimecardChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timecard_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('timecard_id')->references('id')->on('timecards'); //timecard record being changed
            $table->unsignedInteger('user_id')->references('id')->on('users');  //editor
            
            $table->text('notes')->nullable();
            
            $table->string('timecard_old')->nullable();  //JSON timecard object
            $table->string('timecard_new')->nullable();  //JSON timecard object of changes
            
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
        Schema::dropIfExists('timecard_changes');
    }
}
