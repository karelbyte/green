<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCglobalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cglobal_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cglobal_id');
            $table->integer('type_info_id');
            $table->integer('type_info_detail_id');
            $table->string( 'info_descrip', 250);
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
        Schema::dropIfExists('cglobal_infos');
    }
}
