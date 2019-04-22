<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsOfferedsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_offereds_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('products_offereds_id')->unsigned();
            $table->foreign('products_offereds_id')->references('id')->on('products_offereds')->onDelete('cascade');
            $table->string('name');
            $table->integer('measure_id');
            $table->smallInteger('init');
            $table->smallInteger('end');
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
        Schema::dropIfExists('products_offereds_details');
    }
}
