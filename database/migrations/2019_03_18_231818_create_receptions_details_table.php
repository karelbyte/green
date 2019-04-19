<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceptionsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptions_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reception_id')->unsigned();
            $table->integer('item_id');
            $table->double('cant', 8, 2);
            $table->foreign('reception_id')->references('id')->on('receptions')->onDelete('cascade');
            $table->timestamps();
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
        Schema::dropIfExists('receptions_details');
    }
}
