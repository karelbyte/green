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
            $table->date('moment');
            $table->string('note');
            $table->bigInteger('status_id')->unsigned();
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
