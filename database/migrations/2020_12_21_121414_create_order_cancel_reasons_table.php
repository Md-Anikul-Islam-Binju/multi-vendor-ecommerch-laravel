<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCancelReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //admin set order reason & vendor write order cancel reason details
        Schema::create('order_cancel_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reason')->comment('admin set order reason & vendor write order cancel reason details');
            $table->string('reason_details')->nullable();
            $table->string('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('seller_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_type', 11)->nullable();
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_cancel_reasons');
    }
}
