<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            
            $table->string('firstname');
            $table->string('lastname');
            $table->string('mi')->nullable();
            $table->string('suffix')->nullable();
            
            $table->string('image')->nullable();
            
            $table->string('address',255)->nullable();
			$table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();           
            $table->string('phone')->nullable();
            //$table->string('phone_carrier')->nullable();
            $table->integer('carrier_id')->unsigned(); 
                            
            $table->unsignedTinyInteger('is_admin')->default(0); //new for admin-guardian      
                     
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('carrier_id')->references('id')->on('carriers');
        });
        
        /**
         create LONGBLOB columns fingerprint_raw, fingerprint_png
         https://stackoverflow.com/questions/20089652/mediumblob-in-laravel-database-schema 
	    **/
        //DB::statement("ALTER TABLE guardians ADD fingerprint_raw LONGBLOB DEFAULT NULL");
        DB::statement("ALTER TABLE guardians ADD fingerprint_raw VARCHAR(4000) DEFAULT NULL");
        //DB::statement("ALTER TABLE guardians ADD fingerprint_png LONGBLOB DEFAULT NULL");
        DB::statement("ALTER TABLE guardians ADD fingerprint_png VARCHAR(4000) DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardians');
    }
}
