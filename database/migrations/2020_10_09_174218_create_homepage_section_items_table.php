<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageSectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_section_items', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('section_id');
            $table->string('item_title')->nullable();
            $table->string('item_sub_title')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('thumb_image')->nullable();
            $table->text('custom_url')->nullable();
            $table->integer('position')->default(0);
            $table->tinyInteger('is_feature')->default(0);
            $table->tinyInteger('approved')->default(1);
            $table->string('status', 10)->default('pending');
            $table->foreign('section_id')->references('id')->on('homepage_sections')->onDelete('cascade');
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
        Schema::dropIfExists('homepage_section_items');
    }
}
