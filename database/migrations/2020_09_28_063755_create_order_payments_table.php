<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('user_id')->nullable();
            $table->string('paymant_method')->nullable();
            $table->decimal('amount', 8,2);
            $table->string('account_no')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('transaction_details')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('order_payments');
    }
}
