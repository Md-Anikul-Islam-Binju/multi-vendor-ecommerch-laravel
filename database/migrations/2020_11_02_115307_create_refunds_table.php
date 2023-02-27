<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_id', 15);
            $table->integer('product_id');
            $table->integer('qty');
            $table->integer('refund_amount');
            $table->string('return_type', 15);
            $table->string('return_reason');
            $table->integer('seller_id')->nullable();
            $table->tinyInteger('seller_approval')->nullable();
            $table->tinyInteger('admin_approval')->nullable();
            $table->string('refund_status',15)->default('pending');
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
        Schema::dropIfExists('refunds');
    }
}
