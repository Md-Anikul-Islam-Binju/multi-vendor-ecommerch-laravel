<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorySectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('subcategory_id')->nullable();
            $table->string('background_color')->default('#fff');
            $table->string('text_color')->default('#000');
            $table->integer('position')->default(0);
            $table->tinyInteger('is_feature')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('category_sections');
    }
}
