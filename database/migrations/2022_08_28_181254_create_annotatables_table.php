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
        Schema::create('annotatables', function (Blueprint $table) {
            $table->unsignedBigInteger('annotation_id')->unsigned();
            $table->foreign('annotation_id')->references('id')->on('annotations')->onDelete('restrict');

            $table->morphs('annotatable');

            $table->unique(['annotation_id', 'annotatable_id', 'annotatable_type'], 'unique_annotatable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annotatables');
    }
};
