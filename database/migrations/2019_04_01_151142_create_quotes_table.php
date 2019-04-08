<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uid');
            $table->string('token', 5)->nullable();
            $table->string('descrip', 500)->nullable();
            $table->longText('specifications')->nullable();
            $table->integer('cglobal_id');
            $table->integer('type_quote_id');
            $table->smallInteger('sends');
            $table->date('moment');
            $table->smallInteger('status_id');
            $table->smallInteger('type_send_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}
