<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('type')->comment('slider,banner,product');
            $table->string('item_id')->nullable();
            $table->string('layout')->nullable();
            $table->tinyInteger('layout_width')->nullable();
            $table->string('background_color')->default('#fff');
            $table->string('text_color')->default('#000');
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
        Schema::dropIfExists('shop_sections');
    }
}
