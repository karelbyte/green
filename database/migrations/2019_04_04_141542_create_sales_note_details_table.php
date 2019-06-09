<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesNoteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_note_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('salesnotes')->onDelete('cascade');
            $table->integer('type_item');
            $table->integer('item_id');
            $table->string('descrip', 400);
            $table->bigInteger('measure_id')->unsigned();
            $table->decimal('cant');
            $table->decimal('price');
            $table->date('start')->nullable();
            $table->smallInteger('timer')->unsigned()->nullable();
            $table->smallInteger('deliver_product')->unsigned()->default(0);
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
        Schema::dropIfExists('sales_note_details');
    }
}
