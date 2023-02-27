<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('vendor_id')->nullable();
            $table->string('order_id',15);
            $table->string('product_id',12);
            $table->integer('qty');
            $table->decimal('price', 8,2);
            $table->decimal('shipping_charge', 8,2)->nullable();
            $table->decimal('coupon_discount', 8,2)->nullable();
            $table->string('attributes')->nullable();
            $table->tinyInteger('refunded')->nullable();
            $table->string('shipping_status')->default('pending')->comment('pending,process,shipped,reject');
            $table->dateTime('shipping_date')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
