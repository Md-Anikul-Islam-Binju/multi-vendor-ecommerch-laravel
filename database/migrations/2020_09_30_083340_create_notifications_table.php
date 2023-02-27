<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 15)->comment('product, order, adminPay, wallet, refund, blTransfer');
            $table->integer('fromUser')->nullable();
            $table->integer('toUser')->nullable();
            $table->string('item_id', 15)->nullable();
            $table->string('item_id_two', 15)->nullable();
            $table->string('notify')->nullable();
            $table->tinyInteger('read')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
