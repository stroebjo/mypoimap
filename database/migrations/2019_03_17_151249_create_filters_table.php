<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

			// user
			$table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // data
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('mode');
            $table->char('uuid', 36)->nullable()->unique();

            // actual filter data
            $table->json('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
}
