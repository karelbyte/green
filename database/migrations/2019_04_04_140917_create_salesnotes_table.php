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
            $table->integer('global_id');
            $table->date('moment');
            $table->decimal('advance', 8,2)->nullable();
            $table->string('strategy', 500)->nullable();
            $table->smallInteger('status');
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
