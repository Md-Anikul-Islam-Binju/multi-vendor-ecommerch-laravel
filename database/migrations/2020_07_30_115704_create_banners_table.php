<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('banner1')->nullable();
            $table->string('btn_link1')->nullable();
            $table->string('banner2')->nullable();
            $table->string('btn_link2')->nullable();
            $table->string('banner3')->nullable();
            $table->string('btn_link3')->nullable();
            $table->string('banner4')->nullable();
            $table->string('btn_link4')->nullable();
            $table->string('banner5')->nullable();
            $table->string('btn_link5')->nullable();
            $table->integer('banner_type')->nullable();
            $table->string('page_name', 125)->nullable();
            $table->integer('position')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
