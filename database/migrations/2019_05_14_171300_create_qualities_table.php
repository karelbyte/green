<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cglobal_id')->unsigned();
            $table->foreign('cglobal_id')->references('id')->on('cglobals')->onDelete('cascade');
            $table->date('moment');
            $table->date('info_send_date')->nullable();
            $table->date('confirm')->nullable();
            $table->string('url_doc', 250)->nullable();
            $table->string('client_comment', 250)->nullable();
            $table->string('mime', 150)->nullable();
            $table->smallInteger('status_id');
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
        Schema::dropIfExists('qualities');
    }
}
