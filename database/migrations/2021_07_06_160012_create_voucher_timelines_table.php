<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_timelines', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 15);
            $table->string('invoice_id', 15);
            $table->dateTime('invoice_date');
            $table->string('delivery_type', 10)->nullable();
            $table->decimal('voucher_rate', 8, 2)->nullable();
            $table->integer('voucher_qty')->nullable();
            $table->text('notes')->nullable();
            $table->string('shipping_method', 75);
            $table->string('shipping_name', 75)->nullable();
            $table->string('shipping_email', 50)->nullable();
            $table->string('shipping_phone', 15)->nullable();
            $table->string('shipping_country', 25)->default('Bangladesh');
            $table->string('shipping_region', 25)->nullable();
            $table->string('shipping_city', 25)->nullable();
            $table->string('shipping_area', 125)->nullable();
            $table->string('shipping_address', 255)->nullable();
            $table->integer('invoicePrints');
            $table->integer('created_by');
            $table->string('status', 15)->nullable();
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
        Schema::dropIfExists('voucher_timelines');
    }
}
