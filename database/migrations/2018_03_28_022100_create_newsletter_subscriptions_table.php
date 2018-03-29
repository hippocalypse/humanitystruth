<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->email('email')->unique();
            //$table->boolean('authenticated')->default(false);
            //instead lets null this column after user confirms the subscription (using this authenticate_token)
            $table->string('authenticate_token')->nullable()->default(bin2hex(random_bytes(64)));
            $table->string('unsubscribe_token')->default(bin2hex(random_bytes(64)));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
}
