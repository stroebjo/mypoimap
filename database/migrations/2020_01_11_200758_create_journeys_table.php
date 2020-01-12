<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            // user
			$table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // data
            $table->string('title');
            $table->text('description')->nullable();

            $table->date('start');
            $table->date('end');

            $table->text('area')->nullable()->comment("WKT POLYGON");

            $table->text('mode');
            $table->char('uuid', 36)->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journeys');
    }
}
