<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic', function (Blueprint $table) {
            $table->increments('id');
            $table->ipAddress('ip');
            $table->integer('account_id')->default(0);
            $table->text('action');
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traffic');
    }
}
