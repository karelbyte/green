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
            $table->integer('services_offereds_id');
            $table->string('name');
            $table->smallInteger('init');
            $table->smallInteger('end');
            $table->decimal('price', 8, 2);
            $table->smallInteger('measure_id');
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
