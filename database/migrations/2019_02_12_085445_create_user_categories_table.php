<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

			// user
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

            // data
            $table->string('name');
            $table->text('description')->nullable();
            $table->char('color', 7); // HTML5 color input gives 7 cahr color in hex (`#aabbcc`)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_categories');
    }
}
