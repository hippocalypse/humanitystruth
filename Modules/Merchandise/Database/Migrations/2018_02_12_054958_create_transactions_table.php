<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->decimal('amount');
            $table->string('currency');
            $table->string('payer_email');
            $table->string('receiver_email');
            $table->string('tx_id');
            $table->string('number'); //reference
            $table->ipAddress('ip');
            $table->timestamp('timestamp');
        	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
