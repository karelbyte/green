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
            $table->integer('cant');
            $table->integer('descrip');
            $table->decimal('price', 8,2);
            $table->decimal('total', 8,2);
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
        Schema::dropIfExists('quotes_details');
    }
}
