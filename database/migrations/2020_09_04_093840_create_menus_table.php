<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', '25');
            $table->string('slug', '25');
            $table->string('menu_source', '15')->comment('category, page');
            $table->string('source_id', '75')->nullable();
            $table->tinyInteger('top_header')->nullable();
            $table->tinyInteger('main_header')->nullable();
            $table->tinyInteger('footer')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
