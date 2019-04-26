<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesOfferedsNeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_offereds_needs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('services_offereds_detail_id')->unsigned();
            $table->foreign('services_offereds_detail_id')->references('id')
                ->on('services_offereds_details')->onDelete('cascade');
            $table->integer('element_id');
            $table->integer('cant');
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
        Schema::dropIfExists('services_offereds_needs');
    }
}
