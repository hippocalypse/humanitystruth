<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('timestamp');
            $table->string('filename');
            $table->string('location');
            $table->integer('size');
            $table->text('description');
            $table->string('md5', 32);
            $table->string('sha1', 40);
            $table->string('crc32', 32);
            $table->integer('investigation_id');
            $table->enum('relevance', [ 'irrelevant', 'anonymously-uploaded','awaiting-approval-of-operative','awaiting-approval-of-lead-operative','awaiting-approval-of-admin','common-intelligence','suppressed-intelligence','classified-intelligence','critical-intelligence' ] )->default("awaiting-approval-of-operative");
            $table->integer('downloads')->default(0);
        	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
