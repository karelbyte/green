<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 10)->unique();
            $table->smallInteger('type');
            $table->string('name');
            $table->bigInteger('measure_id')->unsigned()->default(1);
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->decimal('price')->default(0);
            $table->smallInteger('wholesale_cant');
            $table->decimal('wholesale_price')->default(0);
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
        Schema::dropIfExists('elements');
    }
}
