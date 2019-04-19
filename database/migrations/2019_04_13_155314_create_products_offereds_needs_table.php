<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsOfferedsNeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_offereds_needs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('products_offereds_detail_id');
            $table->foreign('products_offereds_detail_id')->references('id')->on('products_offereds_details')->onDelete('cascade');
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
        Schema::dropIfExists('product_offereds_needs');
    }
}
