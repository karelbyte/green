<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesOfferedsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_offereds_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('services_offereds_id')->unsigned();
            $table->foreign('services_offereds_id')->references('id')
                ->on('services_offereds')->onDelete('cascade');
            $table->string('name', 50);
            $table->smallInteger('init');
            $table->smallInteger('end');
            $table->decimal('price', 8, 2);
            $table->bigInteger('measure_id')->unsigned();
            $table->foreign('measure_id')->references('id')->on('measures');
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
        Schema::dropIfExists('services_offereds_details');
    }
}
