<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->char('name', 50);
            $table->char('slug', 30);
            $table->integer('display_type')->nullable()->comment('1=flat, 2=select, 3=radio, 4=checkbox');
            $table->tinyInteger('qty')->nullable();
            $table->tinyInteger('price')->nullable();
            $table->tinyInteger('color')->nullable();
            $table->tinyInteger('image')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('orderBy')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('is_default')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('product_attributes');
    }
}
