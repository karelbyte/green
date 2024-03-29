<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('contact');
            $table->string('email')->nullable();
            $table->string('movil', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('street')->nullable();
            $table->string('home_number', 10)->nullable();
            $table->string('colony')->nullable();
            $table->string('referen')->nullable();
            $table->integer('register_to')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
