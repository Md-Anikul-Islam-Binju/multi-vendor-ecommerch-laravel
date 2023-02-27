<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('type', 15);
            $table->string('subtitle')->nullable();
            $table->char('title_size', 5)->default(60)->nullable();
            $table->string('title_color')->default('#000000')->nullable();
            $table->string('title_style')->default('inherit')->nullable();
            $table->char('subtitle_size', 5)->default(50)->nullable();
            $table->string('subtitle_color')->default('#000000')->nullable();
            $table->string('subtitle_style')->default('auto')->nullable();
            $table->string('text_position')->default('left');
            $table->string('bg_color', 255)->nullable();
            $table->string('phato');
            $table->string('btn_text')->default('SHOP NOW')->nullable();
            $table->string('btn_link')->default('#')->nullable();
            $table->integer('position')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
