<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

    		// user
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			// journey (optional)
            $table->unsignedBigInteger('journey_id')->unsigned()->nullable();
            $table->foreign('journey_id')->references('id')->on('journeys')->onDelete('cascade');

            // properties
            $table->string('name');
            $table->text('description')->nullable();

            $table->string('file_name');
            $table->string('file_extension');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('size');

            $table->unsignedInteger('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
