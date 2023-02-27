<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 15);
            $table->integer('user_id');
            $table->integer('total_qty');
            $table->decimal('total_price', 8,2);
            $table->string('coupon_code',25)->nullable();
            $table->decimal('coupon_discount', 8,2)->nullable();
            $table->integer('shipping_method_id')->nullable();
            $table->decimal('shipping_cost')->nullable();
            $table->decimal('offer_shipping')->nullable();
            $table->decimal('shipping_discount')->nullable();
            $table->string('billing_name', 75);
            $table->string('billing_email', 50)->nullable();
            $table->string('billing_phone', 45);
            $table->integer('billing_country')->nullable();
            $table->integer('billing_region')->nullable();
            $table->integer('billing_city')->nullable();
            $table->integer('billing_area')->nullable();
            $table->string('billing_address', 255)->nullable();

            $table->string('shipping_name', 75);
            $table->string('shipping_email', 50)->nullable();
            $table->string('shipping_phone', 45);
            $table->string('shipping_country', 25)->default('Bangladesh');
            $table->string('shipping_region', 25);
            $table->string('shipping_city', 25);
            $table->string('shipping_area', 125);
            $table->string('shipping_address', 255);

            $table->string('order_notes')->nullable();
            $table->integer('affilate_user')->nullable();
            $table->decimal('affilate_amount', 8,2)->nullable();
            $table->string('currency', 6);
            $table->string('currency_sign', 3);
            $table->string('currency_value', 8)->nullable();
            $table->string('payment_method', 20)->default('pending');
            $table->string('tnx_id', 55)->nullable();
            $table->string('payment_info')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->string('payment_status', 10)->default('pending')->comment('pending,process,complete');;
            $table->string('order_status', 10)->default('pending')->comment('pending,process,shipped,reject');;
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
        Schema::dropIfExists('orders');
    }
}
