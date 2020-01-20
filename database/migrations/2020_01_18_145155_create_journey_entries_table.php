<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJourneyEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journey_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            // user
			$table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('journey_id')->unsigned();
            $table->foreign('journey_id')->references('id')->on('journeys')->onDelete('cascade');

            // data
            $table->date('date');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journey_entries');
    }
}
