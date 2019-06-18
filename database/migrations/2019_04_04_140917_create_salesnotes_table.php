<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesnotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('global_id')->unsigned();
            $table->foreign('global_id')->references('id')->on('cglobals')->onDelete('cascade');
            $table->date('moment');
            $table->time('emit');
            $table->decimal('advance')->nullable();
            $table->string('strategy', 500)->nullable();
            $table->date('paimentdate')->nullable();
            $table->date('deliverydate')->nullable();
            $table->decimal('discount')->default(0);
            $table->smallInteger('status_id');
            $table->smallInteger('origin');
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
        Schema::dropIfExists('salesnotes');
    }
}
