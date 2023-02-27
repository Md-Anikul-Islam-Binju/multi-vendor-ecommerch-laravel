<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->integer('product_id');
            $table->integer('offer_discount');
            $table->string('discount_type', '15');
            $table->integer('offer_quantity')->nullable();
            $table->integer('offer_price')->nullable();
            $table->decimal('seller_rate', 8,2)->nullable();
            $table->integer('fake_sale')->default(0);
            $table->tinyInteger('invisible')->nullable();
            $table->tinyInteger('approved')->default('1');
            $table->string('status', 10)->default('pending');
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_products');
    }
}
