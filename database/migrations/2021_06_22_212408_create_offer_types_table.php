<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('sub_title', 255)->nullable();
            $table->string('slug', 255);
            $table->string('image', 255)->nullable();
            $table->string('banner')->nullable();
            $table->string('background_color', 125)->nullable();
            $table->string('text_color', 125)->nullable();
            $table->tinyInteger('position')->default(1);
            $table->tinyInteger('is_default')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_types');
    }
}
