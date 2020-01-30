<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

    		// user
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			// place
			$table->integer('place_id')->unsigned();
			$table->foreign('place_id')->references('id')->on('places');

			// journey (optional)
            $table->unsignedBigInteger('journey_id')->unsigned()->nullable();
            $table->foreign('journey_id')->references('id')->on('journeys')->onDelete('set null');


            // visit
            $table->date('visited_at');
            $table->text('review')->nullable();
            $table->tinyInteger('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
