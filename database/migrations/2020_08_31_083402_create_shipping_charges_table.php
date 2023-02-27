<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('shipping_charges', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_method', 15);
            $table->integer('category_id')->nullable()->comment('product category id');
            $table->integer('region_id')->nullable();
            $table->decimal('basket_price')->nullable();
            $table->decimal('basket_qty')->nullable();
            $table->decimal('shipping_cost')->default(0);
            $table->decimal('other_region_cost')->default(0);
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
        Schema::dropIfExists('shipping_charges');
    }
}
