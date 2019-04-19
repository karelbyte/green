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
            $table->integer('sale_id');
            $table->integer('type_item');
            $table->integer('item_id');
            $table->string('descrip', 400);
            $table->decimal('cant', 8,2);
            $table->decimal('price', 8,2);
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
