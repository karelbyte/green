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
            $table->bigInteger('cglobal_id')->unsigned();
            $table->foreign('cglobal_id')->references('id')->on('cglobals')->onDelete('cascade');;
            $table->integer('type_quote_id');
            $table->smallInteger('sends')->nullable();
            $table->date('moment');
            $table->date('check_date');
            $table->smallInteger('status_id');
            $table->smallInteger('type_send_id')->nullable();
            $table->smallInteger('type_check_id')->nullable();
            $table->mediumText('feedback')->nullable();
            $table->string('strategy', 500)->nullable();
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
        Schema::dropIfExists('quotes');
    }
}
