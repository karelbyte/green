<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void d
     */
    public function up()
    {
        Schema::create('cglobals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('moment');
            $table->time('emit');
            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')
                ->on('clients');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users');
            $table->bigInteger('type_contact_id')->unsigned();
            $table->foreign('type_contact_id')->references('id')
                ->on('type_contacts');
            $table->smallInteger('repeater');
            $table->smallInteger('type_motive');
            $table->smallInteger('type_motive_id');
            $table->smallInteger('required_time');
            $table->smallInteger('type_compromise_id');
            $table->smallInteger('traser');
            $table->string('note',500)->nullable();
            $table->integer('status_id')->default(1);
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
        Schema::dropIfExists('cglobals');
    }
}
