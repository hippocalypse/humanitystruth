<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLightworkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lightworkers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('timestamp');
            $table->integer('account_id');
            $table->ipAddress('ip');
            $table->string('mac');
            $table->integer('ping');
            $table->string('os');
            $table->string('location');
            $table->text('info');
        	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lightworkers');
    }
}
