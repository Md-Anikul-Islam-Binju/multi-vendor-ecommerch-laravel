<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->char('name', 50);
            $table->char('slug', 50);
            $table->unsignedBigInteger('parent_id')->nullable(); //unsignedBigInteger use bcz primary key use bigIncreaments
            $table->integer('subcategory_id')->nullable();
            $table->char('image', 75)->nullable();
            $table->string('notes')->nullable();
            $table->tinyInteger('popular')->default(0);
            $table->integer('menu_id')->nullable();
            $table->integer('orderBy')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->tinyInteger('status')->default(1);
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('categories');
    }
}
