<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            
            $table->string('firstname');
            $table->string('lastname');
            $table->string('mi')->nullable();
            
            $table->string('email')->unique();
            $table->string('password');
            
            //$table->integer('account_number')->unsigned()->nullable();
            $table->unsignedBigInteger('account_number')->nullable();
            
            $table->string('address',255)->nullable();
			$table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();           
            $table->string('phone')->nullable();
            
            $table->rememberToken();
            $table->string('api_token',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('disabled_on')->nullable();  
            
            $table->string('status',20)->default('pending'); //pending, active, disabled         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
