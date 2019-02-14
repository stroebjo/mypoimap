<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

			// foreign
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

            $table->string('title');
            $table->tinyInteger('priority')->nullable();

            $table->string('url')->nullable();
			$table->text('description')->nullable();
            $table->text('source')->nullable();

            $table->point('location');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
