<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->bigInteger('service_offereds_id')->unsigned();
            $table->foreign('service_offereds_id')->references('id')
                ->on('services_offereds_details');
            $table->integer('timer');
            $table->date('start');
            $table->smallInteger('status_id')->unsigned();
            $table->bigInteger('sales_note_details_id')->unsigned();
            $table->foreign('sales_note_details_id')->references('id')
                ->on('sales_note_details')->onDelete('cascade');
            $table->timestamps();
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
        Schema::dropIfExists('maintenances');
    }
}
