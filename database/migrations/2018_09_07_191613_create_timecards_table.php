<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    
        Schema::create('timecards', function (Blueprint $table) {
	        /*
            $table->increments('id');
            
            $table->unsignedInteger('facility_id')->nullable();
            $table->unsignedInteger('student_id')->unsigned();
            
            $table->unsignedInteger('checkin_guardian_id')->unsigned();            
            $table->datetime('checkin_at')->nullable(); //YYYY-MM-DD h:m:s
            
            $table->unsignedInteger('checkout_guardian_id')->nullable();
            $table->datetime('checkout_at')->nullable(); //YYYY-MM-DD h:m:s
            
            $table->datetime('action_at')->nullable(); //YYYY-MM-DD h:m:s
			//$table->timestamp('checkin_at')->useCurrent(); //('CURRENT_TIMESTAMP');
            //$table->unsignedBigInteger('checkout_seconds')->nullable();
            
            $table->text('notes')->nullable();
            //$table->timestamps();
            */
            
            /********************************************************/
            $table->increments('id');
            $table->unsignedInteger('guardian_id')->unsigned();
            $table->unsignedInteger('facility_id')->nullable();
            $table->unsignedInteger('student_id')->unsigned();
            $table->datetime('action_at')->nullable();
            $table->unsignedTinyInteger('is_checkin')->default(0);
            $table->unsignedTinyInteger('is_checkout')->default(0);
            $table->text('notes')->nullable();
            
            $table->datetime('confirmed_at')->nullable();
            $table->unsignedInteger('confirmed_by')->default(0);
        });
        
       // \DB::statement('UPDATE timecards SET checkin_seconds = UNIX_TIMESTAMP(checkin_at)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timecards');
    }
}
