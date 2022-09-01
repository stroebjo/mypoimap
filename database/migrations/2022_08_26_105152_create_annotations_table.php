<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

    		// user
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

            // properties
            $table->string('type');
            $table->string('name');
            $table->text('description')->nullable();

            $table->json('options')->nullable();

            // text?
            $table->text('text')->nullable();

            // file
            $table->string('upload_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annotations');
    }
};
