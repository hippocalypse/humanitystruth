<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestigationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('investigations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('account_id');  //owner
            $table->string('title');  //idea
            $table->string('objective'); //hypothesis
            $table->double('funds')->default(0.00);
            $table->integer('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('investigations');
    }

}
