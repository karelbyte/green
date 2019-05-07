<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCglobalInfoClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cglobal_info_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cglobal_id')->unsigned();
            $table->foreign('cglobal_id')->references('id')->on('cglobals')->onDelete('cascade');
            $table->date('moment');
            $table->smallInteger('type_info_id');
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
        Schema::dropIfExists('cglobal_info_clients');
    }
}
