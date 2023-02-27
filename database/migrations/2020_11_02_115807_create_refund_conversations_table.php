<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_conversations', function (Blueprint $table) {
            $table->id();
            $table->integer('refund_id');
            $table->string('order_id', 15);
            $table->integer('product_id');
            $table->integer('sender_id');
            $table->integer('receiver_id')->nullable();
            $table->text('explain_issue');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('sender_view')->nullable();
            $table->string('receiver_view')->nullable();
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
        Schema::dropIfExists('refund_conversations');
    }
}
