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
            $table->integer('products_offereds_id');
            $table->string('name');
            $table->smallInteger('init');
            $table->smallInteger('end');
            $table->timestamps();
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
