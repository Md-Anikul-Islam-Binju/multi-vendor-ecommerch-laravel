<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('offer_type')->nullable();
            $table->integer('discount')->nullable();
            $table->string('discount_type', '15')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('background_color', 75)->nullable();
            $table->string('text_color', 75)->nullable();
            $table->string('link')->nullable();
            $table->string('allow_item')->nullable();
            $table->text('seller_id')->nullable();
            $table->text('category_id')->nullable();
            $table->text('brand_id')->nullable();
            $table->text('allow_location')->nullable();
            $table->char('shipping_method', 15)->nullable();
            $table->decimal('order_price_above')->nullable();
            $table->integer('order_qty_above')->nullable();
            $table->tinyInteger('free_shipping')->nullable();
            $table->integer('ship_region_id')->nullable();
            $table->decimal('shipping_cost')->nullable();
            $table->decimal('discount_shipping_cost')->nullable();
            $table->decimal('other_region_cost')->nullable();
            $table->char('shipping_time', 50)->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->integer('position')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
