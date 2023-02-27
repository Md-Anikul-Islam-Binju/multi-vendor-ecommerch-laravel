<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('type', 15)->comment('item,category,banner,adds');
            $table->string('display_type')->default('default')->comment('random,custom');
            $table->string('product_id')->nullable();
            $table->string('layout')->nullable();
            $table->tinyInteger('layout_width')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('image_position', 10)->default();
            $table->string('background_color')->default('#fff');
            $table->string('text_color')->default('#000');
            $table->integer('section_manage')->default(1);
            $table->integer('section_number')->nullable();
            $table->integer('item_number')->nullable();
            $table->tinyInteger('section_box_mobile')->nullable();
            $table->tinyInteger('section_box_desktop')->nullable();
            $table->integer('position')->nullable();
            $table->tinyInteger('is_default')->nullable();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homepage_sections');
    }
}
