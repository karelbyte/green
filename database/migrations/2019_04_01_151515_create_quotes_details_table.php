<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quote_id');
            $table->integer('type_item');
            $table->integer('item_id');
            $table->integer('cant');
            $table->string('descrip',500);
            $table->decimal('price', 8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes_details');
    }
}
