<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('maintenance_id')->unsigned();
            $table->foreign('maintenance_id')->references('id')->on('maintenances')->onDelete('cascade');
            $table->bigInteger('sale_id')->unsigned();
            $table->date('moment');
            $table->decimal('price');
            $table->time('visiting_time')->nullable();
            $table->string('note_gardener', 500)->nullable();
            $table->string('note_client', 500)->nullable();
            $table->string('note_advisor', 500)->nullable();
            $table->string('url_commend', 250)->nullable();
            $table->string('mime', 150)->nullable();
            $table->smallInteger('status_id')->unsigned();
            $table->smallInteger('accept')->unsigned();
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
        Schema::dropIfExists('maintenance_details');
    }
}
