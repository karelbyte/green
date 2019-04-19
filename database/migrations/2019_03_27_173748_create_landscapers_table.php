<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandscapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landscapers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cglobal_id');
            $table->date('moment');
            $table->time('timer');
            $table->string('note', 500)->nullable();
            $table->uuid('user_uid');
            $table->integer('status_id')->default(0);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landscapers');
    }
}
